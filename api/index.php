<?php
header("Content-Type: application/json");
$metoda = $_SERVER['REQUEST_METHOD'];
$zahteva = explode("/", trim($_SERVER['PATH_INFO'] ?? '', "/"));

$vir = $zahteva[0] ?? null;
$id = $zahteva[1] ?? null;


require_once "src/upravitelj.php";
obdelajZahtevo($metoda, $vir, $id);

