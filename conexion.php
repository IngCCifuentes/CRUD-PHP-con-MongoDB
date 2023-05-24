<?php
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->selectDatabase('asignaturas');
$collection = $database->selectCollection('materias');
?>
