<?php
session_start();
require('izhodi.php');
require('nastavitve_pb.php');
$povezava = new mysqli($nastavitve['host'], $nastavitve['up_ime'], $nastavitve['up_geslo'], $nastavitve['pb']);
if (!isset($_POST['zeton']) || !isset($_SESSION['zeton']) || $_SESSION['zeton'] != $_POST['zeton']) {
    izhod_v_sili();
}


if (isset($_POST['tip_misli']) && isset($_POST['besedilo']) && isset($_POST['naslov']) && isset($_POST['datum'])) {
    $ukaz = $povezava->prepare('INSERT INTO misel(
        id_tipa_misli,
        datum_objave,
        naslov,
        pot_do_misli
    )
VALUES(
        (
            SELECT id_tipa_misli
            FROM tip_misli
            WHERE naziv_tipa_misli = ?
        ),
        ?,
        ?,
        ?
    )');
    $pot = '../misli/' . $_POST['naslov'] . '.html';
    $ukaz->bind_param('ssss', $_POST['tip_misli'], $_POST['datum'], $_POST['naslov'], $pot);
    $ukaz->execute();

    $odstavki = preg_split("/(\r\n|\r|\n){2,}/", $_POST['besedilo']);

    $html = "";
    foreach ($odstavki as $odstavek) {
        $html .= "<p>" . nl2br(trim($odstavek)) . "</p>\n";
    }
    file_put_contents($pot, $html);

} else {
    izhod_v_sili();
}
header('location: ../admin/misli.php');