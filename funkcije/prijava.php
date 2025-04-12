<?php

session_start();
function izhod_v_sili($s)
{
    $_SESSION['sporocilo'] = $s;
    unset($_SESSION['up_ime']);
    unset($_SESSION['zeton']);
    header('location: ../prijavno_okno/');
    die();
}

if (!isset($_SESSION['zeton']) || $_SESSION['zeton'] != $_POST['zeton']) {
    izhod_v_sili('napacen zeton');
}
if (isset($_POST['up_ime']))
    $up_ime = $_POST['up_ime'];
else
    izhod_v_sili('Ni uporabniškega imena!');

if (isset($_POST['up_geslo']))
    $up_geslo = $_POST['up_geslo'];
else
    izhod_v_sili('Geslo je potrebno!');

$prepovedani_znaki = '/[<>"\'[\]{};]/';
if (preg_match($prepovedani_znaki, $up_ime)) {
    izhod_v_sili('Prepovedani znaki');
}
require('nastavitve_pb.php');
$povezava = new mysqli($nastavitve['host'], $nastavitve['up_ime'], $nastavitve['up_geslo'], $nastavitve['pb']);

if ($povezava->connect_error) {
    die('interna napaka!');
}



$ukaz = $povezava->prepare('SELECT id_uporabnika,up_geslo,up_ime FROM  uporabnik WHERE up_ime = ? AND id_uporabnika NOT IN (SELECT id_uporabnika FROM status INNER JOIN uporabnik_status USING(id_statusa) WHERE naziv = \'blokiran\')');
$ukaz->bind_param('s', $up_ime);
$ukaz->execute();
$rs = $ukaz->get_result();

$_SESSION['up_ime'] = $up_ime;
if ($rs->num_rows > 0) {
    $vrstica = $rs->fetch_assoc();

    $geslo_has = $vrstica['up_geslo'];
    if (password_verify($up_geslo, $geslo_has)) {
        $_SESSION['id_uporabnika'] = $vrstica['id_uporabnika'];
        $_SESSION['up_ime'] = $vrstica['up_ime'];
        $_SESSION['admin'] = false;

        $ukaz = $povezava->prepare('SELECT COUNT(*) FROM uporabnik
         INNER JOIN uporabnik_status USING(id_uporabnika) 
         WHERE up_ime = ? AND id_statusa IN (SELECT id_statusa FROM status WHERE naziv = \'admin\')');
        $ukaz->bind_param('s', $up_ime);
        $ukaz->execute();
        $rs = $ukaz->get_result();
        if ($rs->num_rows > 0) {
            $v = $rs->fetch_assoc();
            if ($v['COUNT(*)'] > 0)
                $_SESSION['admin'] = true;
        }
        header('location: ../glavno/');
        die();
    } else {
        session_destroy();
        izhod_v_sili('Napačno up ime ali geslo');
    }

}
izhod_v_sili('Napačno up ime ali geslo');


