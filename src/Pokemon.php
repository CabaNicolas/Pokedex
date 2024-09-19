<?php
require_once 'DB.php';
class Pokemon
{

    private $id;
    private $numero;
    private $nombre;
    private $tipo;
    private $imagen;
    private $evoluciones;
    private $descripcion;


    public function getPokemons()
    {
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

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function getEvoluciones()
    {
        return $this->evoluciones;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function buscarPokemon($buscado)
    {
        $db = DB::getConexion();
        // Consulta que busca por nombre, número o tipo
        $query = "
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

    private function eliminarDependencias($id)
    {
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

    public function deletePokemon($id)
    {
        $this->eliminarDependencias($id);
        $this->deleteImagen($id);
        $db = DB::getConexion();
        $query = "DELETE FROM pokemon WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }

    private function deleteImagen($id)
    {
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
        $stmt = $pdo->prepare("SELECT p.*, t.nombre AS tipo
        FROM pokemon p
        LEFT JOIN tipo_pokemon tp ON p.id = tp.id_pokemon
        LEFT JOIN tipo t ON tp.id_tipo = t.id
        WHERE p.id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $pokemon = $stmt->fetchObject('Pokemon');
        return $pokemon;
    }

    public function buscarEvoluciones ($numero){
        $pdo = DB::getConexion();
        $stmt = $pdo->prepare("SELECT p2.id, p2.nombre, p2.imagen, p2.descripcion
FROM evolucion e
JOIN pokemon p1 ON e.id_poke = p1.id
JOIN pokemon p2 ON e.id_poke2 = p2.id
WHERE p1.numero = ?");
        $stmt->execute([$numero]);
        $evoluciones = $stmt->fetchAll(PDO::FETCH_CLASS, 'Pokemon');
        return $evoluciones;

    }
}