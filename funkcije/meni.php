

    <nav>
        <section>

            <a href="../glavno/"><button>Domov</button></a>
            <a href="../Jakob_thoughts/"> <button>Jakob thoughts</button></a>
            <a href="../kroky_review/"> <button>Kroky review</button></a>
            <a href="../varen_kokosnjak/"> <button>Varen kokošnjak</button></a>
            <a href="../kazino/"> <button>Kazino</button></a>
            <a href="../tabulature/"> <button>Tabulature</button></a>
            <a href="../vticnica/javno/pc"> <button>Stanje</button></a>
            <?php
            if (isset($_SESSION['admin']) && $_SESSION['admin'])
                echo '<a href="../admin/"><button>Admin</button></a>';
            ?>
        </section>
        <section>
            <?php
            if (!isset($_SESSION['up_ime']))
                echo '<a href="../prijavno_okno"> <button>Prijava</button></a>';
            else
                echo '<a href="../profil"> <button>Profil</button></a>';
            ?>
        </section>
    </nav>