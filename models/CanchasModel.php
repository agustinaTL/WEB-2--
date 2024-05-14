<?php

class CanchasModel{

    private $db;

    public function __construct()
    {
        $this->db = new PDO("mysql:host=localhost;dbname=futbol", "root", "");
    }

    public function getById($id_cancha){
        $query = $this->db->prepare("SELECT * FROM canchas WHERE id = ?");
        $query->execute([$id_cancha]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
}