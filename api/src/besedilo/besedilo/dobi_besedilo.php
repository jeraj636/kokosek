<?php

namespace Besedilo;
require_once __DIR__ . "/../../baza.php";

use Baza;
use BazaException;
use Dotenv\Exception\InvalidFileException;
use LogicException;
function dobiBesedilo($id)
{
    $sql = "SELECT id_misli,naslov,datum_objave,pot_do_misli FROM misel WHERE id_misli = ?";
    $povezava = Baza::poveziSe();
    $stmt = $povezava->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $rez = $stmt->get_result();
    $podatki = $rez->fetch_assoc();

    if (!$podatki) {
        throw new BazaException("Napaka pri pridobivanju posameznega besedila");
    }

    $imeDat = "data/" . $podatki["pot_do_misli"];
    if (file_exists($imeDat)) {
        $dat = fopen($imeDat, "r");
        if (!$dat) {
            throw new InvalidFileException("Napaka pri pridobivanju datoteke");
        }
        $podatki["besedilo"] = fread($dat, filesize($imeDat));
        //pot do misli je nepotrebna in potencialno nevarna za razglašati
        unset($podatki["pot_do_misli"]);
        return json_encode($podatki);
    } else {
        throw new InvalidFileException("Datoteka ne obstaja");
    }
}
