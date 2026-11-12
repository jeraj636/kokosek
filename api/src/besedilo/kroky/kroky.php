<?php

namespace Besedilo;

use LogicException;
use NapacnaApiPoizvedba;
require_once __DIR__ . "/../besedilo/dobi_vsa_besedila.php";
require_once __DIR__ . "/../besedilo/dobi_besedilo.php";

function kroky($podatki)
{
    if (!isset($podatki) || !isset($podatki["id"])) {
        echo dobiVsaBesedila("kroky_review");
    } else {
        echo dobiBesedilo($podatki["id"]);
    }
}
