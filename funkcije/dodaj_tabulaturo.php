<?php
session_start();
require('izhodi.php');
require('nastavitve_pb.php');
$povezava = new mysqli($nastavitve['host'], $nastavitve['up_ime'], $nastavitve['up_geslo'], $nastavitve['pb']);
if (!isset($_POST['zeton']) || !isset($_SESSION['zeton']) || $_SESSION['zeton'] != $_POST['zeton']) {
    izhod_v_sili();
}

if (isset($_POST['id_avtorja']) && isset($_POST['naslov']) && isset($_POST['vsebina']) && isset($_POST['kategorije'])) {
    $pot = '../pesmi/' . $_POST['naslov'] . '.txt';
    $ukaz = $povezava->prepare('INSERT INTO pesem(naslov, pot,id_avtorja) VALUES(?,?,?)');
    if (!$ukaz) {
        die("Napaka pri pripravi SQL ukaza: " . $povezava->error);
    }
    $ukaz->bind_param('ssi', $_POST['naslov'], $pot, $_POST['id_avtorja']);
    $ukaz->execute();

    $ukaz = $povezava->prepare('SELECT id_pesmi FROM pesem ORDER BY id_pesmi DESC LIMIT 1');
    $ukaz->execute();
    $rs = $ukaz->get_result();
    $v = $rs->fetch_assoc();
    $id_pesmi = $v['id_pesmi'];

    $sql = 'INSERT INTO pesem_kategorija VALUES';
    foreach ($_POST['kategorije'] as $kategorija) {
        $sql .= '(' . $id_pesmi . ',' . $kategorija . '),';
    }
    $sql = substr($sql, 0, -1);
    $ukaz = $povezava->prepare($sql);
    $ukaz->execute();
    file_put_contents($pot, $_POST['vsebina']);

} else {
    izhod_v_sili();
}
header('location: ../admin/tabulature.php');