<?php
require('../funkcije/zacetek.php');
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != true) {
    header('location: ../glavno/');
    die();
}
?>
<div class="glavni">
    <h1>Admin</h1>
</div>
<nav>
    <section style="width: 100%; flex-direction: row;">
        <a href="uporabniki.php"><button>Uporabniki</button></a>
        <a href="misli.php"><button>Misli</button></a>
        <a href="tabulature.php"><button>Tabulature</button></a>
    </section>
</nav>

</body>

</html>