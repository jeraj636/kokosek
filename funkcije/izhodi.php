<?php

function izhod_v_sili()
{
    session_destroy();
    header('location: ../glavno/');
    die();
}
