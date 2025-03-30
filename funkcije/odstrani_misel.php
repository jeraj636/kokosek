<?php
session_start();
require('izhodi.php');
require('nastavitve_pb.php');
$povezava = new mysqli($nastavitve['host'], $nastavitve['up_ime'], $nastavitve['up_geslo'], $nastavitve['pb']);
if (!isset($_POST['zeton']) || !isset($_SESSION['zeton']) || $_SESSION['zeton'] != $_POST['zeton']) {
    izhod_v_sili();
}


if (isset($_POST['misel_za_izbris'])) {

    $pot = "";
    $ukaz = $povezava->prepare('SELECT pot_do_misli FROM misel WHERE id_misli = ?');
    $ukaz->bind_param('i', $_POST['misel_za_izbris']);
    $ukaz->execute();
    $rs = $ukaz->get_result();
    if ($rs->num_rows < 1)
        izhod_v_sili();
    $v = $rs->fetch_assoc();
    $pot = $v['pot_do_misli'];
    unlink($pot);
    $ukaz = $povezava->prepare('DELETE FROM misel
WHERE id_misli = ? ');
    $ukaz->bind_param('i', $_POST['misel_za_izbris']);
    $ukaz->execute();
} else {
    izhod_v_sili();
}
header('location: ../admin/misli.php');