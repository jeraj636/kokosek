<?php

use Dotenv\Exception\InvalidPathException;
require_once "baza.php";
function obdelajZahtevo($metoda, $vir, $id)
{
    Baza::init();
    $dovoljeneFunkcije = ["thoughts"];
    if (in_array($vir, $dovoljeneFunkcije)) {
        $vir($metoda, $id);
    } else {
        echo json_encode(["uporabi primeren endpoint"]);
    }
}
function thoughts($metoda, $id)
{
    $notranjaNapaka = ["E" => "notranja napaka"];

    try {

        $povezava = Baza::poveziSe();
        if ($metoda == 'GET' && !isset($id)) {
            $sql = "SELECT id_misli,naslov,datum_objave FROM misel WHERE id_tipa_misli IN (SELECT id_tipa_misli FROM tip_misli WHERE naziv_tipa_misli = 'jakob_thought')";
            try {
                $rezultat = $povezava->query($sql);
                echo json_encode($rezultat->fetch_all(MYSQLI_ASSOC));

            } catch (Exception) {
                echo json_encode($notranjaNapaka);
            }
        } elseif ($metoda == 'GET') {
            $sql = "SELECT id_misli,naslov,datum_objave,pot_do_misli FROM misel WHERE id_misli = ?";
            try {
                $stmt = $povezava->prepare($sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $rez = $stmt->get_result();
                $podatki = $rez->fetch_assoc();

                if (!$podatki) {
                    throw new BazaException("Ni vrstice");
                }

                $imeDat = "data/" . $podatki["pot_do_misli"];
                if (file_exists($imeDat)) {
                    $dat = fopen($imeDat, "r");
                    if (!$dat) {
                        throw new InvalidPathException("Ni datoteke");
                    }
                    $podatki["besedilo"] = fread($dat, filesize($imeDat));
                    //pot do misli je nepotrebna in potencialno nevarna za razglašati
                    unset($podatki["pot_do_misli"]);
                    echo json_encode($podatki);
                } else {
                    echo json_encode($notranjaNapaka);
                    die();
                }
            } catch (Exception) {
                echo json_encode($notranjaNapaka);
            }
        }
    } catch (BazaException) {
        echo json_encode($notranjaNapaka);
    }
}
