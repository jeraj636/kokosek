<?php
session_start();
$ali_sem_prijavljen = false;
if (isset($_SESSION['up_ime'])) {
    $ali_sem_prijavljen = true;
}
?>
<html>

<head lang="si">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <link rel="stylesheet" href="../izgled.css?v=<?= time(); ?>">
</head>

<body>

    <nav>
        <section>

            <a href="../glavno/"><button>Domov</button></a>
            <a href="../Jakob_thoughts/"> <button>Jakob thoughts</button></a>
            <a href="../kroky_review/"> <button>Kroky review</button></a>
            <a href="../glavno/"> <button>Varen kokošnjak</button></a>
            <a href="../glavno/"> <button>Kazino</button></a>
            <a href="../tabulature/"> <button>Tabulature</button></a>
            <a href="../glavno/"> <button>Stanje</button></a>
            <?php
            if (isset($_SESSION['admin']) && $_SESSION['admin'])
                echo '<a href="../admin/"><button>Admin</button></a>';
            ?>
        </section>
        <section>
            <?php
            if (!$ali_sem_prijavljen)
                echo '<a href="../prijavno_okno"> <button>Prijava</button></a>';
            else
                echo '<a href="../profil"> <button>Profil</button></a>';
            ?>
        </section>
    </nav>