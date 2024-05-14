<?php
require_once "./models/CanchasModel.php";
require_once "./models/EquiposModel.php";
require_once "./models/FixturesModel.php";
require_once "./views/FixturesView.php";
require_once "./helpers/AuthHelper.php";

class FixtureController {
    private $model;
    private $equiposModel;
    private $canchasModel;
    private $view;

    public function __construct()
    {
        $this->model = new FixturesModel();
        $this->equiposModel = new EquiposModel();
        $this->canchasModel = new CanchasModel();
        $this->view = new FixturesView();
    }

    public function insertarNueva(){
        // verifico loggueo. Si no esta logueado mato todo
        AuthHelper::verificoLogueo();
        // verifico errores de carga
        if( ! isset($_POST["nro_fecha"]) || ! isset($_POST["equipo_local_id"]) || ! isset($_POST["equipo_visitante_id"]) || ! isset($_POST["hora"]) || ! isset($_POST["id_cancha"])){
            // faltan datos
            $this->view->showError("faltan datos");
            return;
        }
        
        $nro_fecha = $_POST["nro_fecha"];
        $equipo_local_id = $_POST["equipo_local_id"];
        $equipo_visitante_id = $_POST["equipo_visitante_id"];
        $hora = $_POST["hora"];
        $id_cancha = $_POST["id_cancha"];
        
        // verificar equipos y cancha (existen?)
        $equipoLocal = $this->equiposModel->getById($equipo_local_id);

        if( ! $equipoLocal){
            $this->view->showError("No existe el equipo local");
            return;
        }
        
        $equipoVisitante = $this->equiposModel->getById($equipo_visitante_id);

        if( ! $equipoVisitante){
            $this->view->showError("No existe el equipo visitante");
            return;
        }
        
        $cancha = $this->canchasModel->getById($id_cancha);

        if( ! $cancha){
            $this->view->showError("No existe la cancha");
            return;
        }

        // verificar que cancha no esta en otro partido en el mismo horario (hora y fecha)
        $fixtureCanchaHoraFecha = $this->model->getByCanchaHoraFecha($id_cancha, $hora, $nro_fecha);

        if( $fixtureCanchaHoraFecha ){
            $this->view->showError("No se puede asignar la misma cancha para la misma hora y fecha");
            return;
        }

        // verificar que ambos equipos son distintos (para la fixture)
        if ( $equipo_local_id == $equipo_visitante_id){
            $this->view->showError("No se puede asignar el mismo equipo para local y visitante");
            return;
        }

        // verificar que no se asigne el mismo equipo para la misma fecha
        
        $fixtureEquipoRepetidoFecha = $this->model->getByFechaEquiposId($nro_fecha, $equipo_local_id,$equipo_visitante_id);
        if( $fixtureEquipoRepetidoFecha ){
            $this->view->showError("No se puede asignar el mismo equipo para la misma fecha");
            return;
        }

        $exito = $this->model->insert($nro_fecha, $equipo_local_id, $equipo_visitante_id, $hora, $id_cancha);

        if(! $exito ){
            $this->view->showError("Ocurrio un error interno desconocido.");
            return;
        }

        $this->view->showHome();

    }

    public function resumenEquipos(){
        $equipos = $this->equiposModel->getAll();

        //por cada equipo
        foreach ($equipos as $equipo) {
            $equipo->partidos_ganados = 0;
            $equipo->partidos_perdidos = 0;
            $equipo->partidos_empatados = 0;

            $partidos = $this->model->getAllByEquipoId($equipo->id);
            foreach ($partidos as $partido) {
                $resultado = $partido->goles_local - $partido->goles_visitante;

                $soyLocal = $equipo->id == $partido->equipo_local_id;

                if($resultado == 0){
                    $equipo->partidos_empatados++;
                }
                 else if($soyLocal && $resultado > 0 || !$soyLocal && $resultado < 0){
                    $equipo->partidos_ganados++;
                }
                else {
                    $equipo->partidos_perdidos++;
                }
            }
        }

        // ya tengo todos los equipos con los valores de ( ganados, perdidos y empatados )

        $this->view->showResumenEquiposAllPartidos($equipos);
    }
}