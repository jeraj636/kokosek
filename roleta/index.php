<?php


require('../funkcije/zacetek.php');
require('../funkcije/nastavitve_pb.php');

?>
<div class="glavni">
    <h1>Roleta</h1>
    <h1></h1>
    <canvas width="600" height="600" id="platno" ></canvas>
<script>
    window.onload = function() {
        const platno = document.getElementById("platno");
        const ctx = platno.getContext("2d");
        ctx.beginPath();
        ctx.rect(20, 40, 50, 50);
        ctx.fillStyle = "#FF0000";
        ctx.fill();
        ctx.closePath();
    };
</script>


    </script>
    </html>