<?php

class ManjkajocPodatek extends Exception
{
    public function __construct(string $ime_manjkajocega_podatka)
    {
        parent::__construct("Manjka podatek: " . $ime_manjkajocega_podatka);
    }
}
