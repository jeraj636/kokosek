<?php
require('../funkcije/zacetek.php');
require('../funkcije/nastavitve_pb.php');
$povezava = new mysqli($nastavitve['host'], $nastavitve['up_ime'], $nastavitve['up_geslo'], $nastavitve['pb']);

?>
<div class="glavni">
    <h1>Tabulature</h1>
    <h2>Kategorije</h2>
    <?php
    if (!isset($_GET['t_id']) || $_GET['t_id'] == '') {
        $ukaz = $povezava->prepare('SELECT naziv_kategorije,id_kategorije FROM kategorija WHERE id_nad_kategorije IS NULL');
        $ukaz->execute();
        $rs = $ukaz->get_result();
        if ($rs->num_rows > 0)
            while ($v = $rs->fetch_assoc()) {
                echo '<a href="?t_id=' . $v['id_kategorije'] . '"><button>' . $v['naziv_kategorije'] . '</button></a>';
            }
    } else {
        $ukaz = $povezava->prepare('SELECT id_nad_kategorije FROM kategorija WHERE id_kategorije = ?');
        $ukaz->bind_param('i', $_GET['t_id']);
        $ukaz->execute();
        $rs = $ukaz->get_result();
        if ($rs->num_rows > 0)
            while ($v = $rs->fetch_assoc()) {
                echo '<a href="?t_id=' . $v['id_nad_kategorije'] . '"><button>' . 'Nazaj' . '</button></a>';
            }

        $ukaz = $povezava->prepare('SELECT naziv_kategorije,id_kategorije FROM kategorija WHERE id_nad_kategorije = ?');
        $ukaz->bind_param('i', $_GET['t_id']);
        $ukaz->execute();
        $rs = $ukaz->get_result();
        if ($rs->num_rows > 0)
            while ($v = $rs->fetch_assoc()) {
                echo '<a href="?t_id=' . $v['id_kategorije'] . '"><button>' . $v['naziv_kategorije'] . '</button></a>';
            }
    }

    ?>
    <h2>Pesmi</h2>
    <?php
    $ukaz = $povezava->prepare('SELECT naslov,id_pesmi FROM pesem INNER JOIN pesem_kategorija USING (id_pesmi) WHERE id_kategorije = ?');
    $ukaz->bind_param('i', $_GET['t_id']);
    $ukaz->execute();
    $rs = $ukaz->get_result();
    if ($rs->num_rows > 0)
        while ($v = $rs->fetch_assoc()) {
            echo '<a href="pesem.php?p_id=' . $v['id_pesmi'] . '"><button>' . $v['naslov'] . '</button></a>';
        }
    ?>

    </html>