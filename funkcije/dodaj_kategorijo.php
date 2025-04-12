<?php
session_start();
require('izhodi.php');
require('nastavitve_pb.php');
$povezava = new mysqli($nastavitve['host'], $nastavitve['up_ime'], $nastavitve['up_geslo'], $nastavitve['pb']);
if (!isset($_POST['zeton']) || !isset($_SESSION['zeton']) || $_SESSION['zeton'] != $_POST['zeton']) {
    izhod_v_sili();
}


if (isset($_POST['nad_kategorija']) && isset($_POST['naziv'])) {
    if ($_POST['nad_kategorija'] == -1) {
        $ukaz = $povezava->prepare('INSERT INTO kategorija(naziv_kategorije) VALUES(?)');
        $ukaz->bind_param('s', $_POST['naziv']);
        $ukaz->execute();
    } else {

        $ukaz = $povezava->prepare('INSERT INTO kategorija(naziv_kategorije,id_nad_kategorije) VALUES(?,?)');
        $ukaz->bind_param('si', $_POST['naziv'], $_POST['nad_kategorija']);
        $ukaz->execute();
    }
} else {
    izhod_v_sili();
}
header('location: ../admin/tabulature.php');