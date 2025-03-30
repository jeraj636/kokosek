<?php
require('../funkcije/zacetek.php');
require('../funkcije/nastavitve_pb.php');
require('../funkcije/izhodi.php');
$povezava = new mysqli($nastavitve['host'], $nastavitve['up_ime'], $nastavitve['up_geslo'], $nastavitve['pb']);

?>
<div class="glavni">
    <?php
    $ukaz = $povezava->prepare('SELECT naslov,pot , CONCAT(ime,\' \', priimek) AS p_ime FROM pesem INNER JOIN avtor USING (id_avtorja) WHERE id_pesmi = ?');
    if (!isset($_GET['p_id']))
        izhod_v_sili();
    $ukaz->bind_param('i', $_GET['p_id']);
    $ukaz->execute();
    $rs = $ukaz->get_result();
    $pesem = $rs->fetch_assoc();
    echo '<h1>' . $pesem['naslov'] . '</h1>';
    echo '<h3>' . $pesem['p_ime'] . '</h3>';
    $vsebina = file_get_contents($pesem['pot']);
    ?>
    <pre><?= $vsebina ?></pre>
</div>

</html>