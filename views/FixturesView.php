<?php

class FixturesView{
    
    public function showError(){

    }
    public function showHome(){

    }
    public function showResumenEquiposAllPartidos($equipos){
        include "./templates/resumenEquipos.phtml";
    }
}