<?php

use function Besedilo\besedilo;
use function Uporabnik\uporabnik;

require_once __DIR__ . "/baza.php";
require_once __DIR__ . "/uporabnik/uporabnik.php";
require_once __DIR__ . "/besedilo/besedilo.php";
function obdelajZahtevo($metoda, $vir, $akcija)
{
    try {
        Baza::init();
    } catch (BazaException $e) {
        die();
    }

    $dovoljeneFunkcije = ["besedilo" => "Besedilo\\besedilo", "uporabnik" => "Uporabnik\\uporabnik"];

    if (isset($dovoljeneFunkcije[$vir])) {
        $dovoljeneFunkcije[$vir]($metoda, $akcija);
    } else {
        die();
    }
}
