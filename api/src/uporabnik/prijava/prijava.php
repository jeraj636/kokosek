<?php

namespace Uporabnik;

use LogicException;
use ManjkajocPodatek;
use Baza;
function prijava($podatki)
{
    if (!isset($podatki)) {
        die(json_encode(["info" => "Manjkajo podatki."]));
    }

    if (!isset($podatki["up_ime"])) {
        die(json_encode(["info" => "Manjka uporabniško ime."]));
    }

    if (!isset($podatki["up_geslo"])) {
        die(json_encode(["info" => "Manjka geslo."]));
    }
    $upIme = $podatki["up_ime"];
    $upGeslo = $podatki["up_geslo"];


    $sql = "SELECT up_geslo FROM uporabnik WHERE up_ime = ?";
    $povezava = Baza::poveziSe();
    $stmt = $povezava->prepare($sql);
    $stmt->bind_param("s", $upIme);
    $stmt->execute();
    $rez = $stmt->get_result();
    if ($rez === false) {
        echo json_encode(["info" => "Napacno uporabnisko ime ali geslo"]);
        die();
    }
    $gesloBaza = $rez->fetch_assoc()["up_geslo"];
    if (password_verify($upGeslo, $gesloBaza)) {
        // inicializacija seje
        session_start();
        session_regenerate_id(true);
        $_SESSION["id"] = $podatki["id"];
        echo json_encode(["info" => "ok"]);
    } else {
        echo json_encode(["info" => "Napacno uporabnisko ime ali geslo"]);
    }
}
