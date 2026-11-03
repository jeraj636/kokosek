<?php
require_once "besedila.php";

function reviews($metoda, $id)
{
    if ($metoda == 'GET' && !isset($id)) {
        $json = vsaBesedila("kroky_review");
        echo $json;

    } elseif ($metoda == 'GET' && isset($id) && is_numeric($id)) {
        $json = specificnoBesedilo($id);
        echo $json;
    }
}
