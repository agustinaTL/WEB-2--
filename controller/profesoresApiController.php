<?php
require_once 'model/profesorModel.php';
require_once 'model/opinionModel.php';
require_once 'view/apiView.php';


class ProfesoresApiController
{
    private $profesorModel;
    private $opinionModel;
    private $apiView;
    private $data;

    public function __construct()
    {
        $this->profesorModel = new ProfesorModel();
        $this->opinionModel = new OpinionModel();
        $this->apiView = new ApiView();
        $this->data = file_get_contents("php://input");
    }

    // Decodifica un JSON y lo convierte en un objeto
    private function getData()
    {
        return json_decode($this->data);
    }

    // TABLA DE RUTEO:
    // Obtener Lista de Profesores:

    public function obtenerProfesores()
    {
        $profesores = $this->profesorModel->obtenerProfesores();
        return $this->apiView->response($profesores, 200);
    }

    // Obtener un Profesor:
    public function obtenerProfesorId($params = [])
    {
        $id = $params[':id'];
        $profesor = $this->profesorModel->getProfById($id);
        return $this->apiView->response($profesor, 200);
    }

    // Eliminar un Profesor:
    public function eliminarProfesorId($params = [])
    {
        $id = $params[':id'];
        $profesor = $this->profesorModel->eliminarProfesorId($id);
        return $this->apiView->response($profesor, 200);
    }

    // Obtener Lista de Profesores ordenada por imagen Positiva asc o desc: (EN TABLA OPINION)

    public function obtenerListaImagenPositiva($params = [])
    {
        $id_profesor = $params[':id_profesor'];
        $profesores = $this->profesorModel->obtenerProfesores();

        foreach ($profesores as $profesor) {
            $obtenerOpiniones = $this->opinionModel->getOpinionesById($id_profesor);

            $obtenerLista = $this->opinionModel->calcularImagenPositiva($obtenerOpiniones);
        }

        return $this->apiView->response($obtenerLista, 200);
    }

    public function profOrdenImagenPositiva($params = [])
    {
        // Obtiene la lista de profesores
        $profesores = $this->profesorModel->obtenerProfesores();

        //Recorre cada profesor calculando la imagen positiva de cada uno
        foreach ($profesores as $profesor) {
            $id_profesor = $profesor->$this->id;

            // Obtener las opiniones del profesor
            $opiniones = $this->opinionModel->getOpinionesById($id_profesor);

            // Obtiene el porcentaje de imagen positiva para el profesor
            $porcentajePositivo = $this->opinionModel->calcularImagenPositiva($opiniones);

            // Combinar el porcentaje y los datos en un solo array
            $profConPorcentaje = [
                'porcentajePositivo' => $porcentajePositivo,
                'datosProfesor' => $profesor
            ];
            $profesoresConPorcentaje[] = $profConPorcentaje;
        }

        $porcentajePositivo = $params[':IMAGENPOSITIVA']; //nombre de columna que deseo ordenar 

        //Consulta si or :ORDEN valor mandado via api es ASCENDENTE o DESCENDENTE.
        if ($params[':ORDER'] == "ASC") {

            //de ser ASC mando los profesores y sus porcentajes o nombre de columna a ordernar.                                       
            $profesoresConPorcentaje =  $this->profesorModel->imagenPositivaOrderASC($profesor, $porcentajePositivo);
        } else if ($params[':ORDER'] == "DESC") {
            $profesoresConPorcentaje =  $this->profesorModel->imagenPositivaOrderDESC($profesor, $porcentajePositivo);
        }
        return $profesoresConPorcentaje;
    }

    public function peliculaFiltro($params = [])
    {
        $genero = $_GET['genero'];
        $director = $_GET['director'];

        $pelicula = $this->peliculaModel->obtenerPeliculaByGeneroYDirector($genero, $director);

        $peliculaFiltrada = $params[':GENERO&DIRECTOR:']; //nombre de columnas que deseo filtrar (género y director)

    }
}
