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
    <h1>Misli</h1>
</div>
<h2>Dodaj misel</h2>
<form action="../funkcije/dodaj_misel.php" method="post">
    <textarea name="besedilo"></textarea>
    <input type="text" hidden="hidden" style="display: none;" name="zeton" value="<?= $_SESSION['zeton'] ?>">
    <select name="tip_misli">
        <?php
        $ukaz = $povezava->prepare('SELECT naziv_tipa_misli FROM tip_misli');
        $ukaz->execute();
        $rs = $ukaz->get_result();
        if ($rs->num_rows > 0) {
            while ($v = $rs->fetch_assoc()) {
                echo '<option>' . $v['naziv_tipa_misli'] . '</option>';
            }
        }
        ?>
    </select>
    <div>
        <label>Naslov: </label>

        <input type="text" name="naslov">
    </div>
    <div>
        <label>Datum: </label>

        <input type="date" name=" datum">
    </div>
    <input type="submit" value="Potrdi">
</form>

<table>
    <tr>
        <th>Id</th>
        <th>Naslov</th>
        <th>Pot</th>
        <th>Datum</th>
        <th>Tip misli</th>
        <th>Izbris</th>
    </tr>
    <?php
    $ukaz = $povezava->prepare('SELECT id_misli,
    naslov,
    pot_do_misli,
    datum_objave,
    naziv_tipa_misli
FROM misel
    INNER JOIN tip_misli USING(id_tipa_misli)');
    $ukaz->execute();
    $rs = $ukaz->get_result();
    if ($rs->num_rows > 0) {
        while ($v = $rs->fetch_assoc()) {
            echo '<tr><td>' . $v['id_misli'] . '</td><td>' . $v['naslov'] . '</td><td>' . $v['pot_do_misli'] . '</td><td>' . $v['datum_objave'] . '</td><td>' . $v['naziv_tipa_misli'] . '</td><td>
            <form action="../funkcije/odstrani_misel.php" method="post">
                <input type="text" hidden="hidden" style="display: none;" name="zeton" value="' . $_SESSION['zeton'] . '">
                <button type="submit" value="' . $v['id_misli'] . '"name="misel_za_izbris">Izbriši</button>
            </form>
            </td></tr>';
        }
    }
    ?>
</table>
</body>

</html>