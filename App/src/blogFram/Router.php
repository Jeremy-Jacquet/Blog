<?php

namespace App\src\blogFram;
use Exception;

class Router
{
    private $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    public function run()
    {
        $route = $this->request->getGet()->get('route');
        try {
            echo '<b>Site en cours de construction...</b>';
        }
        catch (Exception $e) {
        }
    }
}