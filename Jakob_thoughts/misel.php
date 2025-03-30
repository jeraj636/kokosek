<?php
require('../funkcije/zacetek.php');
?>
<div class="glavni">
    <div class="misel">
        <?php
        require('../funkcije/nastavitve_pb.php');
        $povezava = new mysqli($nastavitve['host'], $nastavitve['up_ime'], $nastavitve['up_geslo'], $nastavitve['pb']);
        if (!isset($_GET['misel'])) {
            header('location: index.php');
            die();
        }
        $podatki_o_misli;
        $ukaz = $povezava->prepare('SELECT * FROM misel WHERE id_misli = ?');
        $ukaz->bind_param('i', $_GET['misel']);
        $ukaz->execute();
        $rs = $ukaz->get_result();
        if ($rs->num_rows > 0)
            $podatki_o_misli = $rs->fetch_assoc();

        echo '<h1>' . $podatki_o_misli['naslov'] . '</h1>';
        echo '<h3>' . $podatki_o_misli['datum_objave'] . '</h3>';
        $vsebina = file_get_contents($podatki_o_misli['pot_do_misli']);
        echo $vsebina;
        ?>

    </div>
</div>

</html>