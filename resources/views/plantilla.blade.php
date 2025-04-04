<?php

function crearHeader($titulo)
{
    echo "<!DOCTYPE html>";
    echo "<html lang='es'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>$titulo</title>";
    echo "<link rel='stylesheet', href={{ asset('css/AdminSolicitudes.css') }}>";
    echo "</head>";
}

/*Generar Menu*/
function generarMenu($items)
{
    echo "<nav><ul>";
    foreach ($items as $nombre => $link) {
        echo "<li><a href='$link'>$nombre</a></li>";
    }
    echo "</ul></nav>";
}


/*Generar Body*/
function generarBody($titulo, $contenido)
{
    echo "<body>";
    echo "<h1>$titulo</h1>";
    echo "<p>$contenido</p>";
    echo "<img src='car/logo.png' alt='Descripción de la imagen'>";
    echo "</body>";
}





?>
