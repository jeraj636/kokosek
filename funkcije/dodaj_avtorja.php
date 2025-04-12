<?php
session_start();
require('izhodi.php');
require('nastavitve_pb.php');
$povezava = new mysqli($nastavitve['host'], $nastavitve['up_ime'], $nastavitve['up_geslo'], $nastavitve['pb']);
if (!isset($_POST['zeton']) || !isset($_SESSION['zeton']) || $_SESSION['zeton'] != $_POST['zeton']) {
    izhod_v_sili();
}


if (isset($_POST['ime']) && isset($_POST['priimek'])) {
    $ukaz = $povezava->prepare('INSERT INTO avtor(ime,priimek) VALUES(?,?)');
    $ukaz->bind_param('ss', $_POST['ime'], $_POST['priimek']);
    $ukaz->execute();
} else {
    izhod_v_sili();
}
header('location: ../admin/tabulature.php');