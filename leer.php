<?php
$documents = $collection->find([])->sort(['-id' => 1]);

foreach ($documents as $document) {
    echo "Nombre: " . $document['nombre'] . "<br>";
    echo "id_estudiante: " . $document['id_estudiante'] . "<br>";

    echo "Edad: " . $document['edad'] . "<br>";
    echo "Email: " . $document['email'] . "<br>";
    echo "<br>";
}
?>
