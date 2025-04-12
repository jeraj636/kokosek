<?php
session_start();
$zeton = bin2hex(random_bytes(32));
$_SESSION['zeton'] = $zeton;
?>


</html>

<!DOCTYPE html>
<html>

<head>
    <?php require('../funkcije/glava.php'); ?>
</head>

<body>
    <?php require('../funkcije/meni.php'); ?>
    <div class="glavni">
        <h1>Registracija</h1>
        <?php
        if (isset($_SESSION['sporocilo'])) {
            echo '<p>' . $_SESSION['sporocilo'] . '</p>';
        }
        ?>
        <form action="../funkcije/registracija.php" method="post" autocomplete="off">
            <input type="text" hidden="hidden" style="display: none;" name="zeton" value="<?= $zeton ?>">
            <div>

                <label>Uporabniško ime:</label>
                <input type="text" name="up_ime" autocomplete="off">
            </div>
            <div>
                <label>Geslo:</label>
                <input type="password" name="up_geslo" autocomplete="off">
            </div>
            <input type="submit" name="Prijava" value="Registracija">
        </form>
    </div>
</body>

</html>