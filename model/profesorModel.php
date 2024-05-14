<?php

class ProfesorModel
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO("");
    }

    public function getProfById($id)
    {

        $query = $this->db->prepare("SELECT * FROM profesor WHERE id = ?");
        $query->execute($id);
        $datosProf = $query->fetch(PDO::FETCH_OBJ);
        return $datosProf;
    }

    public function obtenerProfesores()
    {
        $query = $this->db->prepare("SELECT * FROM profesor");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function eliminarProfesorId($id)
    {
        $query = $this->db->prepare("DELETE * FROM profesor WHERE id = ?");
        $query->execute($id);
        return $query->fetch(PDO::FETCH_OBJ);
    }
}
