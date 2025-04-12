<?php

session_start();
require('izhodi.php');
function izhod($sporocilo)
{
    $_SESSION['sporocilo'] = $sporocilo;
    header('location: ../reg_okno/');

}


if (!isset($_SESSION['zeton']) || $_SESSION['zeton'] != $_POST['zeton']) {
    izhod_v_sili();
}

if (isset($_POST['up_ime']))
    $up_ime = $_POST['up_ime'];
else
    izhod_v_sili();

if (isset($_POST['up_geslo']))
    $up_geslo = $_POST['up_geslo'];
else
    izhod_v_sili();

//filtriranje vhodnih podatkov
if (strlen($up_ime) <= 3) {
    izhod('Uporabniško ime je prekratko!');
}
if (strlen($up_geslo) <= 8) {
    izhod('Geslo je prekratko!');
}

$prepovedani_znaki = '/[<>"\'[\]{};]/';
if (preg_match($prepovedani_znaki, $up_ime)) {
    izhod('Uporabniško ime vsebuje prepovedane znake!');
}

require('nastavitve_pb.php');
$povezava = new mysqli($nastavitve['host'], $nastavitve['up_ime'], $nastavitve['up_geslo'], $nastavitve['pb']);

if ($povezava->connect_error) {
    die('interna napaka!');
}

$up_geslo = password_hash($up_geslo, PASSWORD_DEFAULT);

$ukaz = $povezava->prepare('INSERT INTO uporabnik (up_ime,up_geslo) VALUES(?,?)');
$ukaz->bind_param('ss', $up_ime, $up_geslo);
if (!$ukaz->execute())
    izhod('Uporabnik s tem imenom že obstaja');

$ukaz = $povezava->prepare('INSERT INTO kazino (id_uporabnika,st_jajc) VALUES((SELECT id_uporabnika FROM  uporabnik WHERE up_ime = ?),1000)');
$ukaz->bind_param('s', $up_ime);
if (!$ukaz->execute())
    izhod_v_sili();

$ukaz = $povezava->prepare('SELECT id_uporabnika,up_ime FROM  uporabnik WHERE up_ime = ?');
$ukaz->bind_param('s', $up_ime);
$ukaz->execute();
$rs = $ukaz->get_result();

$_SESSION['up_ime'] = $up_ime;
if ($rs->num_rows > 0) {
    $vrstica = $rs->fetch_assoc();
    $_SESSION['id_uporabnika'] = $vrstica['id_uporabnika'];
    $_SESSION['up_ime'] = $vrstica['up_ime'];
}
unset($_SESSION['id_uporabnika']);
unset($_SESSION['up_ime']);
$_SESSION['sporocilo'] = 'Za dokončanje registracije se prijavi!';
header('location: ../prijavno_okno/');
