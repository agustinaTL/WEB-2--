<?php

class FixturesModel{

    private $db;

    public function __construct()
    {
        $this->db = new PDO("mysql:host=localhost;dbname=futbol", "root", "");
    }

    public function getByCanchaHoraFecha($id_cancha, $hora, $nro_fecha){
        $query = $this->db->prepare("SELECT * FROM partidos WHERE id_cancha = ? AND hora = ? AND nro_fecha = ?");
        $query->execute([$id_cancha, $hora, $nro_fecha]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function getByFechaEquiposId($nro_fecha, $equipo_local_id, $equipo_visitante_id){
        $query = $this->db->prepare("SELECT * FROM partidos WHERE nro_fecha = ? AND equipo_local_id = ? OR equipo_visitante_id = ?");
        $query->execute([$nro_fecha, $equipo_local_id, $equipo_visitante_id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function insert($nro_fecha, $equipo_local_id, $equipo_visitante_id, $hora, $id_cancha){
        $query = $this->db->prepare("INSERT INTO partidos(nro_fecha, equipo_local_id, equipo_visitante_id, hora, id_cancha, goles_local, goles_visitante, jugado) values (?, ?, ?, ?, ?, 0, 0, 0)");
        return $query->execute([$nro_fecha, $equipo_local_id, $equipo_visitante_id, $hora, $id_cancha]);
    }

    public function getAllByEquipoId($equipo_id){
        $query = $this->db->prepare("SELECT * FROM partidos WHERE equipo_local_id = ? OR equipo_visitante_id = ?");
        $query->execute([$equipo_id, $equipo_id]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

}