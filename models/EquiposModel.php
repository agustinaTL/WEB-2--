<?php

class EquiposModel{

    private $db;

    public function __construct()
    {
        $this->db = new PDO("mysql:host=localhost;dbname=futbol", "root", "");
    }

    public function getById($equipo_id){
        $query = $this->db->prepare("SELECT * FROM equipos WHERE id = ?");
        $query->execute([$equipo_id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
    public function getAll(){
        $query = $this->db->prepare("SELECT * FROM equipos");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    
}