<?php
require('../funkcije/zacetek.php');
$zeton = bin2hex(random_bytes(32));
$_SESSION['zeton'] = $zeton;
?>
<div class="glavni">
    <h1>Prijava</h1>
    <?php
    if (isset($_SESSION['sporocilo']))
        echo '<p>' . $_SESSION['sporocilo'] . '</p>'
            ?>
        <form action="../funkcije/prijava.php" method="post">
            <input type="text" hidden="hidden" style="display: none;" name="zeton" value="<?= $zeton ?>">
        <div>

            <label>Uporabniško ime:</label>
            <input type="text" name="up_ime">
        </div>
        <div>
            <label>Geslo:</label>
            <input type="password" name="up_geslo">
        </div>
        <input type="submit" name="Prijava" value="Prijavi se">
    </form>
    <p>Še nimaš računa?</p>
    <a href="../reg_okno"><button>Registriraj se</button></a>
</div>

</html>