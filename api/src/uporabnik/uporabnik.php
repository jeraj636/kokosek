<?php
namespace Uporabnik;

require_once __DIR__ . "/../izjeme/NapacnaMetoda.php";
require_once __DIR__ . "/prijava/prijava.php";
require_once __DIR__ . "/registracija/registracija.php";

use NapacnaMetoda;

function uporabnik($metoda, $akcija)
{
    if ($metoda !== "POST") {
        throw new NapacnaMetoda($metoda);
    }

    $podatki = json_decode(file_get_contents("php://input"), true);


    $dovoljeneAkcije = [
        "prijava" => __NAMESPACE__ . "\\prijava",
        "registracija" => __NAMESPACE__ . "\\registracija"
    ];

    if (isset($dovoljeneAkcije[$akcija])) {
        $dovoljeneAkcije[$akcija]($podatki);
    }
}
