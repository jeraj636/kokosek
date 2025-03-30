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
    <h1>Tabulature</h1>
    <h2>Dodaj avtorja</h2>
    <form action="../funkcije/dodaj_avtorja.php" method="post">
        <input type="text" hidden="hidden" style="display: none;" name="zeton" value="<?= $_SESSION['zeton'] ?>">
        <div>
            <label>Ime:</label>
            <input type="text" name="ime">
        </div>
        <div>
            <label>Priimek:</label>
            <input type="text" name="priimek">
        </div>
        <input type="submit" value="Potrdi">
    </form>
    <h2>Odstrani avtorja</h2>
    <form action="../funkcije/odstrani_avtorja.php" method="post">
        <input type="text" hidden="hidden" style="display: none;" name="zeton" value="<?= $_SESSION['zeton'] ?>">
        <select name="id_avtorja">
            <?php
            $ukaz = $povezava->prepare('SELECT CONCAT(ime,\' \',priimek) AS p_ime, id_avtorja FROM avtor');
            $ukaz->execute();
            $rs = $ukaz->get_result();
            if ($rs->num_rows > 0) {
                while ($v = $rs->fetch_assoc()) {
                    echo '<option value="' . $v['id_avtorja'] . '">' . $v['p_ime'] . '</optnion>';
                }
            }
            ?>
        </select>
        <input type="submit" value="Potrdi">
    </form>
    <h2>Dodaj kategorijo</h2>
    <form action="../funkcije/dodaj_kategorijo.php" method="post">
        <input type="text" hidden="hidden" style="display: none;" name="zeton" value="<?= $_SESSION['zeton'] ?>">
        <div>
            <label>Kategorija:</label>
            <input type="text" name="naziv">
        </div>
        <div>
            <label>Nad kategorija:</label>
            <select name="nad_kategorija">
                <option value="-1">Brez</option>
                <?php
                $ukaz = $povezava->prepare('SELECT naziv_kategorije, id_kategorije  FROM kategorija');
                $ukaz->execute();
                $rs = $ukaz->get_result();
                if ($rs->num_rows > 0) {
                    while ($v = $rs->fetch_assoc()) {
                        echo '<option value="' . $v['id_kategorije'] . '">' . $v['naziv_kategorije'] . '</optnion>';
                    }
                }
                ?>
            </select>
        </div>
        <input type="submit" value="Potrdi">
    </form>
    <h2>Odstrani kategorijo</h2>
    <form action="../funkcije/odstrani_kategorijo.php" method="post">
        <input type="text" hidden="hidden" style="display: none;" name="zeton" value="<?= $_SESSION['zeton'] ?>">
        <select name="id_kategorije">
            <?php
            $ukaz = $povezava->prepare('WITH RECURSIVE category_path AS (
    SELECT id_kategorije,
        naziv_kategorije,
        id_nad_kategorije,
        naziv_kategorije AS path
    FROM kategorija
    WHERE id_nad_kategorije IS NULL
    UNION ALL
    SELECT k.id_kategorije,
        k.naziv_kategorije,
        k.id_nad_kategorije,
        CONCAT(cp.path, \'/\', k.naziv_kategorije) AS path
    FROM kategorija k
        INNER JOIN category_path cp ON k.id_nad_kategorije = cp.id_kategorije
)
SELECT cp.id_kategorije AS id_kategorije,
    cp.path AS hierarhija
FROM category_path cp');
            $ukaz->execute();
            $rs = $ukaz->get_result();
            if ($rs->num_rows > 0) {
                while ($v = $rs->fetch_assoc()) {
                    echo '<option value="' . $v['id_kategorije'] . '">' . $v['hierarhija'] . '</optnion>';
                }
            }
            ?>
        </select>
        <input type="submit" value="Potrdi">
    </form>
    <h2>Odstrani tabulaturo</h2>
    <form action="../funkcije/odstrani_tabulaturo.php" method="post">
        <input type="text" hidden="hidden" style="display: none;" name="zeton" value="<?= $_SESSION['zeton'] ?>">
        <select name="id_pesmi">
            <?php
            $ukaz = $povezava->prepare('SELECT naslov, id_pesmi FROM pesem');
            $ukaz->execute();
            $rs = $ukaz->get_result();
            if ($rs->num_rows > 0) {
                while ($v = $rs->fetch_assoc()) {
                    echo '<option value="' . $v['id_pesmi'] . '">' . $v['naslov'] . '</optnion>';
                }
            }
            ?>
        </select>
        <input type="submit" value="Potrdi">
    </form>
    <h2>Dodaj tabulaturo</h2>
    <form action="../funkcije/dodaj_tabulaturo.php" method="post">
        <input type="text" hidden="hidden" style="display: none;" name="zeton" value="<?= $_SESSION['zeton'] ?>">
        <div>
            <label>Avtor: </label>
            <select name="id_avtorja">
                <?php
                $ukaz = $povezava->prepare('SELECT CONCAT(ime,\' \',priimek) AS p_ime, id_avtorja  FROM avtor');
                $ukaz->execute();
                $rs = $ukaz->get_result();
                if ($rs->num_rows > 0) {
                    while ($v = $rs->fetch_assoc()) {
                        echo '<option value="' . $v['id_avtorja'] . '">' . $v['p_ime'] . '</optnion>';
                    }
                }
                ?>
            </select>
        </div>
        <div>
            <label>Naslov:</label>
            <input type="text" name="naslov">
        </div>
        <textarea style="width: 40vw; margin: 2vh;" name="vsebina"></textarea>
        <?php
        $ukaz = $povezava->prepare('WITH RECURSIVE category_path AS (
    SELECT id_kategorije,
        naziv_kategorije,
        id_nad_kategorije,
        naziv_kategorije AS path
    FROM kategorija
    WHERE id_nad_kategorije IS NULL
    UNION ALL
    SELECT k.id_kategorije,
        k.naziv_kategorije,
        k.id_nad_kategorije,
        CONCAT(cp.path, \'/\', k.naziv_kategorije) AS path
    FROM kategorija k
        INNER JOIN category_path cp ON k.id_nad_kategorije = cp.id_kategorije
)
SELECT cp.id_kategorije AS id_kategorije,
    cp.path AS hierarhija
FROM category_path cp');
        $ukaz->execute();
        $rs = $ukaz->get_result();
        if ($rs->num_rows > 0) {
            while ($v = $rs->fetch_assoc()) {
                echo '<div><input type="checkbox" name="kategorije[]" value="' . $v['id_kategorije'] . '"><p style="display: inline-block; margin: 0;">' . $v['hierarhija'] . '</p></div>';
            }
        }
        ?>
        <input type="submit" value="Potrdi">

    </form>
</div>


</body>

</html>