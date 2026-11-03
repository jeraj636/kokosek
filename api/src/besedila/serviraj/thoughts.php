<?php
require_once "besedila.php";

function thoughts($metoda, $id)
{
    if ($metoda == 'GET' && !isset($id)) {
        $json = vsaBesedila("jakob_thought");
        echo $json;

    } elseif ($metoda == 'GET' && isset($id) && is_numeric($id)) {
        $json = specificnoBesedilo($id);
        echo $json;
    }
}
