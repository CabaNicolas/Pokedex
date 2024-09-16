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

    public function buscarPokemon($buscado) {
        $db = DB::getConexion();
        // Consulta que busca por nombre, número o tipo
        $query = "SELECT p.* FROM pokemon p
              LEFT JOIN tipo_pokemon tp ON p.id = tp.id_pokemon
              LEFT JOIN tipo t ON tp.id_tipo = t.id
              WHERE p.nombre LIKE :buscado
              OR p.numero = :buscadoNumero
              OR t.nombre LIKE :buscado";
        $stmt = $db->prepare($query);
        $buscadoNumero = is_numeric($buscado) ? $buscado : null;
        $stmt->bindValue(':buscado', "%$buscado%");
        $stmt->bindValue(':buscadoNumero', $buscadoNumero);
        $stmt->execute();
        $pokemons = $stmt->fetchAll(PDO::FETCH_CLASS, 'Pokemon');
        return $pokemons;
    }
}
