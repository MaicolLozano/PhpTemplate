<?php

namespace Controllers;


class HomeController
{
    public function index()
    {
        $heading = "Plantilla";

      require views('index.view.php');
    }
}