<?php
require_once 'DB.php';
class Pokemon{

    private $numero;
    private $nombre;
    private $tipo;
    private $imagen;
    private $evoluciones;
    private $descripcion;



    public function getPokemons(){
        $db = DB::getConexion();
        $query = "SELECT * FROM pokemon";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $pokemons = $stmt->fetchAll(PDO::FETCH_CLASS, 'Pokemon');
        return $pokemons;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getNumero(){
        return $this->numero;
    }

    public function getEvoluciones(){
        return $this->evoluciones;
    }

    public function getTipo(){
        return $this->tipo;
    }

    public function getImagen(){
        return $this->imagen;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

}
