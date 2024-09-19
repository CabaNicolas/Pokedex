<?php
require_once 'DB.php';
class Pokemon{

    private $id;
    private $numero;
    private $nombre;
    private $tipo;
    private $imagen;
    private $evoluciones;
    private $descripcion;



    public function getPokemons(){
        $db = DB::getConexion();
        $query = "
            SELECT p.*, t.nombre AS tipo, 
                   ( SELECT e.id_poke2 
                     FROM evolucion e 
                     WHERE e.id_poke = p.id AND e.id_poke2 != p.id ) 
                     AS evoluciones 
            FROM pokemon p 
            LEFT JOIN tipo_pokemon tp ON p.id = tp.id_pokemon 
            LEFT JOIN tipo t ON tp.id_tipo = t.id 
            ORDER BY p.numero;
        ";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $pokemons = $stmt->fetchAll(PDO::FETCH_CLASS, 'Pokemon');
        return $pokemons;
    }

    public function getPokemonById($id) {
        $db = DB::getConexion();

        $query = "
        SELECT p.*, t.nombre AS tipo, 
               ( SELECT e.id_poke2 
                 FROM evolucion e 
                 WHERE e.id_poke = p.id AND e.id_poke2 != p.id ) 
                 AS evoluciones 
        FROM pokemon p 
        LEFT JOIN tipo_pokemon tp ON p.id = tp.id_pokemon 
        LEFT JOIN tipo t ON tp.id_tipo = t.id 
        WHERE p.id = :id
        LIMIT 1;
    ";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $pokemon = $stmt->fetchObject('Pokemon');

        return $pokemon ? $pokemon : null;
    }


    public function getId(){
        return $this->id;
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
        $query =  "
            SELECT p.*, t.nombre AS tipo
            FROM pokemon p
            LEFT JOIN tipo_pokemon tp ON p.id = tp.id_pokemon
            LEFT JOIN tipo t ON tp.id_tipo = t.id
            WHERE p.nombre LIKE :buscado
              OR p.numero = :buscadoNumero
              OR t.nombre LIKE :buscado
        ";
        $stmt = $db->prepare($query);
        $buscadoNumero = is_numeric($buscado) ? $buscado : null;
        $stmt->bindValue(':buscado', "%$buscado%");
        $stmt->bindValue(':buscadoNumero', $buscadoNumero);
        $stmt->execute();
        $pokemons = $stmt->fetchAll(PDO::FETCH_CLASS, 'Pokemon');
        return $pokemons;
    }

    private function eliminarDependencias($id) {
        $db = DB::getConexion();
        $query = "DELETE FROM evolucion WHERE id_poke = :id OR id_poke2 = :id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $query = "DELETE FROM tipo_pokemon WHERE id_pokemon = :id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }
    public function deletePokemon($id) {
        $this->eliminarDependencias($id);
        $this->deleteImagen($id);
        $db = DB::getConexion();
        $query = "DELETE FROM pokemon WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }

    private function deleteImagen($id) {
        $db = DB::getConexion();
        $query = "SELECT imagen FROM pokemon WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $imagen = $stmt->fetchColumn();
        if (file_exists($imagen)) {
            unlink($imagen);
        }
    }

    public function createPokemon($nombre, $numero, $tipos, $imagen, $descripcion) {
        $db = DB::getConexion();

        // validar si el numero ya existe
        $query = "SELECT COUNT(*) FROM pokemon WHERE numero = :numero";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':numero', $numero);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            echo "Error: Ya existe un Pokémon con el número $numero.";
            return;
        }

        $query = "INSERT INTO pokemon (nombre, numero, imagen, descripcion) 
              VALUES (:nombre, :numero, :imagen, :descripcion)";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':nombre', $nombre);
        $stmt->bindValue(':numero', $numero);
        $stmt->bindValue(':imagen', $imagen);
        $stmt->bindValue(':descripcion', $descripcion);
        $stmt->execute();

        $pokemonId = $db->lastInsertId();

        // verificar que los tipos existen en la tabla tipo
        $query = "SELECT id FROM tipo WHERE id IN (" . implode(',', array_fill(0, count($tipos), '?')) . ")";
        $stmt = $db->prepare($query);
        $stmt->execute($tipos);
        $validTypes = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

        // insertar los tipos asociados en la tabla tipo_pokemon
        foreach ($tipos as $tipo) {
            if (in_array($tipo, $validTypes)) { //verifica si el tipo es valido
                $query = "INSERT INTO tipo_pokemon (id_pokemon, id_tipo) 
                      VALUES (:id_pokemon, :id_tipo)";
                $stmt = $db->prepare($query);
                $stmt->bindValue(':id_pokemon', $pokemonId);
                $stmt->bindValue(':id_tipo', $tipo);
                $stmt->execute();
            } else {
                echo "Tipo no válido: $tipo";
            }
        }

        return $pokemonId;
    }

    public function modificatePokemon($id, $nombre = null, $numero = null, $tipos = [], $descripcion = null,  $imagen = null) {
        $db = DB::getConexion();
        $updates = [];
        $params = [':id' => $id];

        if (!is_null($nombre)) {
            $updates[] = "nombre = :nombre";
            $params[':nombre'] = $nombre;
        }

        if (!is_null($numero)) {
            $updates[] = "numero = :numero";
            $params[':numero'] = $numero;
        }


        if (!is_null($descripcion)) {
            $updates[] = "descripcion = :descripcion";
            $params[':descripcion'] = $descripcion;
        }

        if (!is_null($imagen)) {
            $updates[] = "imagen = :imagen";
            $params[':imagen'] = $imagen;
        }

        if (count($updates) > 0) {
            $query = "UPDATE pokemon SET " . implode(', ', $updates) . " WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->execute($params);
        }

        if (!empty($tipos)) {
            $query = "DELETE FROM tipo_pokemon WHERE id_pokemon = :id";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            foreach ($tipos as $tipo) {
                $query = "INSERT INTO tipo_pokemon (id_pokemon, id_tipo) VALUES (:id_pokemon, :id_tipo)";
                $stmt = $db->prepare($query);
                $stmt->bindValue(':id_pokemon', $id);
                $stmt->bindValue(':id_tipo', $tipo);
                $stmt->execute();
            }
        }

        return true;
    }


}
