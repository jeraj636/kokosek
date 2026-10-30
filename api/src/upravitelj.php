<?php

function obdelajZahtevo($metoda, $vir, $id)
{
    $dovoljeneFunkcije = ["thoughts"];
    if (in_array($vir, $dovoljeneFunkcije)) {
        $vir($metoda, $id);
    }
}

function thoughts($metoda, $id)
{
    // TODO SQL poizvedba
    if ($metoda == 'GET' && !isset($id)) {
        // TODO vrni vse misli
    } elseif ($metoda == 'GET') {
        // TODO vrni posamezno misel
    }
}
