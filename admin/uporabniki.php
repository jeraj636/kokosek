<?php
require('../funkcije/zacetek.php');
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != true) {
    header('location: ../glavno/');
    die();
}
$_SESSION['zeton'] = bin2hex(random_bytes(32));
require('../funkcije/nastavitve_pb.php');
$povezava = new mysqli($nastavitve['host'], $nastavitve['up_ime'], $nastavitve['up_geslo'], $nastavitve['pb']);

?>
<div class="glavni">
    <h1>Uporabniki</h1>
</div>
<h2>Dodaj status</h2>
<form action="../funkcije/dodaj_status.php" method="post">
    <input type="text" hidden="hidden" style="display: none;" name="zeton" value="<?= $_SESSION['zeton'] ?>">
    <select name="uporabnik">
        <?php
        $ukaz = $povezava->prepare('SELECT up_ime FROM uporabnik');
        $ukaz->execute();
        $rs = $ukaz->get_result();
        if ($rs->num_rows > 0) {
            while ($v = $rs->fetch_assoc()) {
                echo '<option>' . $v['up_ime'] . '</option>';
            }
        }
        ?>
    </select>
    <select name="status">
        <?php
        $ukaz = $povezava->prepare('SELECT naziv FROM status');
        $ukaz->execute();
        $rs = $ukaz->get_result();
        if ($rs->num_rows > 0) {
            while ($v = $rs->fetch_assoc()) {
                echo '<option>' . $v['naziv'] . '</option>';
            }
        }
        ?>
    </select>
    <input type="submit" value="Potrdi">
</form>
<h2>Odstrani status</h2>

<form action="../funkcije/odstrani_status.php" method="post">
    <input type="text" hidden="hidden" style="display: none;" name="zeton" value="<?= $_SESSION['zeton'] ?>">
    <select name="uporabnik">
        <?php
        $ukaz = $povezava->prepare('SELECT up_ime FROM uporabnik');
        $ukaz->execute();
        $rs = $ukaz->get_result();
        if ($rs->num_rows > 0) {
            while ($v = $rs->fetch_assoc()) {
                echo '<option>' . $v['up_ime'] . '</option>';
            }
        }
        ?>
    </select>
    <select name="status">
        <?php
        $ukaz = $povezava->prepare('SELECT naziv FROM status');
        $ukaz->execute();
        $rs = $ukaz->get_result();
        if ($rs->num_rows > 0) {
            while ($v = $rs->fetch_assoc()) {
                echo '<option>' . $v['naziv'] . '</option>';
            }
        }
        ?>
    </select>
    <input type="submit" value="Potrdi">
</form>
<table>
    <tr>
        <th>Id</th>
        <th>Up ime</th>
        <th>Status</th>
        <th>St jajc</th>
    </tr>
    <?php
    $ukaz = $povezava->prepare('SELECT id_uporabnika,
    up_ime,
    st_jajc,
    GROUP_CONCAT(naziv SEPARATOR \', \') AS nazivi
FROM uporabnik
    INNER JOIN kazino USING (id_uporabnika)
    LEFT JOIN uporabnik_status USING (id_uporabnika)
    LEFT JOIN status USING (id_statusa)
GROUP BY id_uporabnika;');
    $ukaz->execute();
    $rs = $ukaz->get_result();
    if ($rs->num_rows > 0) {
        while ($v = $rs->fetch_assoc()) {
            echo '<tr><td>' . $v['id_uporabnika'] . '</td><td>' . $v['up_ime'] . '</td><td>' . $v['nazivi'] . '</td><td>' . $v['st_jajc'] . '</td></tr>';
        }
    }
    ?>
</table>
</body>

</html>