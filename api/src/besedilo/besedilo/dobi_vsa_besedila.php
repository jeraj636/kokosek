<?php

namespace Besedilo;
require_once __DIR__ . "/../../baza.php";
use LogicException;
use Baza;
function dobiVsaBesedila($tip)
{
    $povezava = Baza::poveziSe();
    $sql = "SELECT id_misli,naslov,datum_objave FROM misel WHERE id_tipa_misli IN (SELECT id_tipa_misli FROM tip_misli WHERE naziv_tipa_misli = ?) ORDER BY datum_objave DESC";
    $stmt = $povezava->prepare($sql);
    $stmt->bind_param("s", $tip);
    $stmt->execute();
    $rezultat = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return json_encode($rezultat);
}
