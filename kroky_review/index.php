<?php
require('../funkcije/zacetek.php');
require('../funkcije/nastavitve_pb.php');
$povezava = new mysqli($nastavitve['host'], $nastavitve['up_ime'], $nastavitve['up_geslo'], $nastavitve['pb']);

?>
<div class="glavni">
    <h1>Kroky review</h1>
    <?php
    $ukaz = $povezava->prepare('SELECT id_misli, naslov FROM misel WHERE id_tipa_misli IN (SELECT id_tipa_misli FROM tip_misli WHERE naziv_tipa_misli = \'kroky_review\') ORDER BY datum_objave DESC');
    $ukaz->execute();
    $rs = $ukaz->get_result();
    if ($rs->num_rows > 0)
        while ($v = $rs->fetch_assoc()) {
            echo '<a href="misel.php?misel=' . $v['id_misli'] . '"><button>' . $v['naslov'] . '</button></a>';
        }
    ?>

    </html>