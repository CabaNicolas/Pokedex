<?php
$id =$_POST['id'];
require_once __DIR__ . '/src/Pokemon.php';
$Pokemon = new Pokemon();
$Pokemon->deletePokemon($id);

header("Location: index.php");
exit();