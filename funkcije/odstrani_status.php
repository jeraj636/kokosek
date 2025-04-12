<?php
session_start();
require('izhodi.php');
require('nastavitve_pb.php');
$povezava = new mysqli($nastavitve['host'], $nastavitve['up_ime'], $nastavitve['up_geslo'], $nastavitve['pb']);
if (!isset($_POST['zeton']) || !isset($_SESSION['zeton']) || $_SESSION['zeton'] != $_POST['zeton']) {
    izhod_v_sili();
}


if (isset($_POST['uporabnik']) && isset($_POST['status'])) {
    $ukaz = $povezava->prepare('DELETE FROM uporabnik_status
WHERE id_uporabnika =
        (
            SELECT id_uporabnika
            FROM uporabnik
            WHERE up_ime = ?
        )AND id_statusa =
        (
            SELECT id_statusa
            FROM status
            WHERE naziv = ?
        )
    ');
    $ukaz->bind_param('ss', $_POST['uporabnik'], $_POST['status']);
    $ukaz->execute();
} else {
    izhod_v_sili();
}
header('location: ../admin/uporabniki.php');