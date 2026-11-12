<?php

namespace Besedilo;

require_once __DIR__ . "/../izjeme/NapacnaMetoda.php";
require_once __DIR__ . "/thought/thought.php";
require_once __DIR__ . "/kroky/kroky.php";
use NapacnaMetoda;
function besedilo($metoda, $akcija)
{
    if ($metoda !== "POST") {
        throw new NapacnaMetoda($metoda);
    }
    $podatki = json_decode(file_get_contents("php://input"), true);
    $dovoljeneAkcije = [
        "thought" => __NAMESPACE__ . "\\thought",
        "kroky" => __NAMESPACE__ . "\\kroky"
    ];

    if (isset($dovoljeneAkcije[$akcija])) {
        $dovoljeneAkcije[$akcija]($podatki);
    }
}
