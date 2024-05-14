<?php
require_once 'model/profesorModel.php';
require_once 'model/opinionModel.php';
require_once 'view/view.php';


class opinionController
{
    private $profesorModel;
    private $opinionModel;
    private $view;

    public function __construct()
    {
        $this->profesorModel = new ProfesorModel();
        $this->opinionModel = new OpinionModel();
        $this->view = new View();
    }

    public function mostrarFormulario()
    {
        $this->view->mostrarFormulario();
    }

    public function insertarOpinion()
    {
        //no permitir posibles errores
        // por ej, que DNI y las demás variables ingresadas no estén vacías

        // if (AuthHelper::getAlumnoUser()) {
        $dni = $_POST['dni'];
        $fecha = $_POST['fecha'];
        $imagen = $_POST['imagen'];
        $id_profesor = $_POST['id_profesor'];

        if (empty($dni) || empty($fecha) || empty($imagen) || empty($id_profesor)) {

            // Verificar si el alumno ya ha votado por este profesor
            if ($this->opinionModel->existeOpinionDeAlumnoParaProfesor($dni, $id_profesor)) {
                // Si ya ha votado, mostrar un mensaje de error o realizar alguna acción apropiada
                return "Error: Ya has votado por este profesor anteriormente";
            } else {
                $this->opinionModel->addOpinion($dni, $fecha, $imagen, $id_profesor);
                return "¡Opinión registrada exitosamente!";
            }

            // }
        }
    }


    public function obtenerImagenProf($id_profesor)
    {

        // Obtener los datos del profesor por su ID
        $datosProf = $this->profesorModel->getProfById($id_profesor);

        // Obtener las opiniones del profesor 
        $arreglo = $this->opinionModel->getOpinionesById($id_profesor);

        // Calcular los porcentajes positivo y negativo (select * where id_prof=? en el modelo)
        $porcentajePositivo = $this->imagenPositiva($arreglo);
        $porcentajeNegativo = $this->imagenNegativa($arreglo);

        // Combinar los porcentajes en un solo array
        $imagenProf = [
            'porcentajePositivo' => $porcentajePositivo,
            'porcentajeNegativo' => $porcentajeNegativo,
            'datosProfesor' => $datosProf
        ];

        return $imagenProf;
    }

    public function imagenNegativa($arreglo)
    {
        // return porcentaje
    }


    public function imagenPositiva($arreglo)
    {
        // return porcentaje
    }
}
