<?php
function umri()
{
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    die();
    exit; // ker mu ne zaupam
}
