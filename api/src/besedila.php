<?php
require_once "umri.php";
function specificnoBesedilo($id)
{
    if (!isset($id)) {
        umri();
    }
    try {
        $sql = "SELECT id_misli,naslov,datum_objave,pot_do_misli FROM misel WHERE id_misli = ?";
        $povezava = Baza::poveziSe();
        $stmt = $povezava->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $rez = $stmt->get_result();
        $podatki = $rez->fetch_assoc();

        if (!$podatki) {
            umri();
        }

        $imeDat = "data/" . $podatki["pot_do_misli"];
        if (file_exists($imeDat)) {
            $dat = fopen($imeDat, "r");
            if (!$dat) {
                umri();
            }
            $podatki["besedilo"] = fread($dat, filesize($imeDat));
            //pot do misli je nepotrebna in potencialno nevarna za razglašati
            unset($podatki["pot_do_misli"]);
            return json_encode($podatki);
        } else {
            umri();
        }
    } catch (Exception) {
        umri();
    }
}

function vsaBesedila($tip_misli)
{
    if (!isset($tip_misli) || $tip_misli === "") {
        umri();
    }

    try {
        $povezava = Baza::poveziSe();
        $sql = "SELECT id_misli,naslov,datum_objave FROM misel WHERE id_tipa_misli IN (SELECT id_tipa_misli FROM tip_misli WHERE naziv_tipa_misli = ?) ORDER BY datum_objave DESC";
        $stmt = $povezava->prepare($sql);
        $stmt->bind_param("s", $tip_misli);
        $stmt->execute();
        $rezultat = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return json_encode($rezultat);

    } catch (Exception) {
        umri();
    }
}
