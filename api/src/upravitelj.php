<?php

require_once "baza.php";
require_once "thoughts.php";

function obdelajZahtevo($metoda, $vir, $id)
{
    Baza::init();
    $dovoljeneFunkcije = ["thoughts"];
    if (in_array($vir, $dovoljeneFunkcije)) {
        $vir($metoda, $id);
    } else {
        echo json_encode(["uporabi primeren endpoint"]);
    }
}
