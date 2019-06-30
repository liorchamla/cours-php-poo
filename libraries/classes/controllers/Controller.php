<?php

namespace Controllers;

abstract class Controller
{

    protected $modelName;
    protected $model;

    public function __construct()
    {
        $realModelName = "\\Models\\" . $this->modelName;
        $this->model = new $realModelName();
    }
}
