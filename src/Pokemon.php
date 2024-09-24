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
            SELECT p.*, 
                   ( SELECT GROUP_CONCAT(t.nombre) 
                     FROM tipo_pokemon tp 
                     INNER JOIN tipo t ON tp.id_tipo = t.id 
                     WHERE tp.id_pokemon = p.id 
                     GROUP BY tp.id_pokemon ) AS tipo,
                   ( SELECT GROUP_CONCAT(e.id_poke2) 
                     FROM evolucion e 
                     WHERE e.id_poke = p.id AND e.id_poke2 != p.id 
                     GROUP BY e.id_poke ) AS evoluciones 
            FROM pokemon p 
            ORDER BY p.numero;
        ";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $pokemons = $stmt->fetchAll(PDO::FETCH_CLASS, 'Pokemon');
        return $pokemons;
    }

    public function getId()
    {
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
            SELECT p.*, 
                   ( SELECT GROUP_CONCAT(t.nombre) 
                     FROM tipo_pokemon tp 
                     INNER JOIN tipo t ON tp.id_tipo = t.id 
                     WHERE tp.id_pokemon = p.id 
                     GROUP BY tp.id_pokemon ) AS tipo
            FROM pokemon p
            LEFT JOIN tipo_pokemon tp ON p.id = tp.id_pokemon
            LEFT JOIN tipo t ON tp.id_tipo = t.id
            WHERE p.nombre LIKE :buscado
              OR p.numero = :buscadoNumero
              OR t.nombre LIKE :buscado
            GROUP BY p.id
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

    public function buscarPokemonPorId($id)
    {
        $pdo = DB::getConexion();
        $stmt = $pdo->prepare("SELECT p.*, (
                SELECT GROUP_CONCAT(t.nombre)
                FROM tipo_pokemon tp
                INNER JOIN tipo t ON tp.id_tipo = t.id
                WHERE tp.id_pokemon = p.id
                GROUP BY tp.id_pokemon) AS tipo
            FROM pokemon p
            LEFT JOIN tipo_pokemon tp ON p.id = tp.id_pokemon
            LEFT JOIN tipo t ON tp.id_tipo = t.id
            WHERE p.id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $pokemon = $stmt->fetchObject('Pokemon');
        return $pokemon;
    }

    public function tipos(){
        $db = DB::getConexion();
        $query = "SELECT * FROM tipo";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $tipos = $stmt->fetchAll();
        return $tipos;
    }

    public function insertarPokemon($nombre, $numero, $imagen, $descripcion){
        $db = DB::getConexion();
        $query = "INSERT INTO pokemon (nombre, numero, imagen, descripcion) 
              VALUES (:nombre, :numero, :imagen, :descripcion)";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':nombre', $nombre);
        $stmt->bindValue(':numero', $numero);
        $stmt->bindValue(':imagen', $imagen);
        $stmt->bindValue(':descripcion', $descripcion);
        $stmt->execute();
        return $db->lastInsertId();
    }

    public function verificarSiExisteTipos($tipos) {
        $db = DB::getConexion();
        $query = "SELECT id FROM tipo WHERE nombre IN (" . implode(',', array_fill(0, count($tipos), '?')) . ")";
        $stmt = $db->prepare($query);
        $stmt->execute($tipos);
        $validTypes = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        echo var_dump($validTypes);
        echo var_dump($tipos);
        return $validTypes;
    }

    public function verificarSiExistePokemons($evoluciones) {
        if(empty($evoluciones)) return [];
        $db = DB::getConexion();
        $query = "SELECT id FROM pokemon WHERE id IN (" . implode(',', array_fill(0, count($evoluciones), '?')) . ")";
        $stmt = $db->prepare($query);
        $stmt->execute($evoluciones);
        $validEvolutions = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        return $validEvolutions;
    }

    public function modificatePokemon($id, $nombre = null, $numero = null, $tipos = [], $evoluciones = [], $descripcion = null,  $imagen = null) {
        $db = DB::getConexion();

        $imagenVieja = $this->buscarPokemonPorId($id)->getImagen();
        if (file_exists($imagenVieja) && $imagenVieja != $imagen && !empty($imagenVieja) && !empty($imagen)) {
            unlink($imagenVieja);
        }

        $updates = [];
        $params = [
            ':id' => $id
        ];

        if (!empty($nombre)) {
            $updates[] = 'nombre = :nombre';
            $params[':nombre'] = $nombre;
        }

        if (!empty($numero)) {
            $updates[] = 'numero = :numero';
            $params[':numero'] = $numero;
        }

        if (!empty($descripcion)) {
            $updates[] = 'descripcion = :descripcion';
            $params[':descripcion'] = $descripcion;
        }

        if (!empty($imagen)) {
            $updates[] = 'imagen = :imagen';
            $params[':imagen'] = $imagen;
        }

        if (count($updates) > 0) {
            $query = "UPDATE pokemon SET " . implode(', ', $updates) . " WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->execute($params);
        }

        if (!empty($evoluciones)) {
            $query = "DELETE FROM evolucion WHERE id_poke = :id";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            foreach ($evoluciones as $evolucion) {
                $query = "INSERT INTO evolucion (id_poke, id_poke2) VALUES (:id_poke, :id_poke2)";
                $stmt = $db->prepare($query);
                $stmt->bindValue(':id_poke', $id);
                $stmt->bindValue(':id_poke2', $evolucion);
                $stmt->execute();
            }
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

    public function insertarTipoPokemon($pokemonId, $validTypes) {
        $db = DB::getConexion();
        foreach ($validTypes as $tipo) {
            $query = "INSERT INTO tipo_pokemon (id_pokemon, id_tipo) VALUES (:id_pokemon, :id_tipo)";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':id_pokemon', $pokemonId);
            $stmt->bindValue(':id_tipo', $tipo);
            $stmt->execute();
        }
    }

    public function insertarEvolucionPokemon($pokemonId, $validEvolutions) {
        $db = DB::getConexion();
        foreach ($validEvolutions as $evolution) {
            $query = "INSERT INTO evolucion (id_poke, id_poke2) VALUES (:id_poke, :id_poke2)";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':id_poke', $pokemonId);
            $stmt->bindValue(':id_poke2', $evolution);
            $stmt->execute();
        }
    }

    public function buscarEvoluciones ($id){
        $pdo = DB::getConexion();
        $stmt = $pdo->prepare("SELECT p2.id, p2.nombre, p2.imagen, p2.descripcion
            FROM evolucion e
            JOIN pokemon p1 ON e.id_poke = p1.id
            JOIN pokemon p2 ON e.id_poke2 = p2.id
            WHERE p1.numero = ?");
        $stmt->execute([$id]);
        $evoluciones = $stmt->fetchAll(PDO::FETCH_CLASS, 'Pokemon');
        return $evoluciones;

    }
}