<?php
require_once "baza.php";
function obdelajZahtevo($metoda, $vir, $id)
{
    Baza::init();
    $dovoljeneFunkcije = ["thoughts"];
    if (in_array($vir, $dovoljeneFunkcije)) {
        $vir($metoda, $id);
    }
}

function thoughts($metoda, $id)
{
    try {

        $povezava = Baza::poveziSe();
        if ($metoda == 'GET' && !isset($id)) {
            //TODO filtracija
            $sql = "SELECT id_misli,naslov,datum_objave FROM misel WHERE id_tipa_misli = SELECT id";
            $rezultat = $povezava->query($sql);
            echo json_encode($rezultat->fetch_all(MYSQLI_ASSOC));
        } elseif ($metoda == 'GET') {
            // TODO vrni posamezno misel
        }
    } catch (BazaException) {
        echo "o ne!";
    }
}
