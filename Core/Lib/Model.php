<?php

namespace Core\Lib;

class Model extends \medoo {
    public function __construct()
    {
        $config = Conf::all('Database');
        parent::__construct($config);
    }
}