<?php

class OpinionModel
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO("");
    }

    public function addOpinion($dni, $fecha, $imagen, $id_profesor)
    {
        $query = $this->db->prepare("INSERT INTO Opinion (dni, fecha, imagen, id_profesor) VALUES (?,?,?,?)");
        return $query->execute([$dni, $fecha, $imagen, $id_profesor]);
    }
    public function calcularImagenPositiva($opiniones) //arreglo: hay opiniones de un profesor
    {
        //return $porcentajePositivoProfesor
    }

    public function calcularImagenNegativa($opiniones)
    {
        //return $porcentajeNegativoProfesor
    }

    public function getOpinionesById($id_profesor)
    {
        // Consulta SQL para obtener todas las opiniones del profesor por su ID
        $query = $this->db->prepare("SELECT * FROM opinion WHERE id_profesor = ?");
        // Ejecutar la consulta con el valor del parámetro
        $query->execute($id_profesor);
        // Obtener todas las filas que coincidan con el ID del profesor
        $opiniones = $query->fetch(PDO::FETCH_OBJ);
        return $opiniones; // las guardo en un arreglo.
    }

    public function existeOpinionDeAlumnoParaProfesor($dniAlumno, $idProfesor)
    {
    }

    public function obtenerListaImagenPositivaProfesor($porcentajePositivoProfesor)
    {
    }
}
