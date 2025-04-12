<?php
session_start();
require('izhodi.php');
require('nastavitve_pb.php');
$povezava = new mysqli($nastavitve['host'], $nastavitve['up_ime'], $nastavitve['up_geslo'], $nastavitve['pb']);
if (!isset($_POST['zeton']) || !isset($_SESSION['zeton']) || $_SESSION['zeton'] != $_POST['zeton']) {
    izhod_v_sili();
}

if (isset($_POST['id_kategorije'])) {
    $ukaz = $povezava->prepare('DELETE FROM kategorija WHERE id_kategorije = ?');
    $ukaz->bind_param('i', $_POST['id_kategorije']);
    $ukaz->execute();
} else {
    izhod_v_sili();
}
header('location: ../admin/tabulature.php');