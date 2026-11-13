<?php

namespace Besedilo;

require_once __DIR__ . "/../besedilo/dobi_vsa_besedila.php";
require_once __DIR__ . "/../besedilo/dobi_besedilo.php";
function thought($podatki)
{

    if (!isset($podatki) || !isset($podatki["id"])) {
        echo dobiVsaBesedila("jakob_thought");
    } else {
        echo dobiBesedilo($podatki["id"]);
    }
}
