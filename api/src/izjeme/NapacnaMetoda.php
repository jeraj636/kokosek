<?php

class NapacnaMetoda extends Exception
{
    public function __construct(string $metoda)
    {
        parent::__construct("Uporabljena je bila napačna metoda: " . $metoda);
    }
}
