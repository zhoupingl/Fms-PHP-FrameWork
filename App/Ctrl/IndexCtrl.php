<?php

namespace App\Ctrl;

use Core\Fms;

class IndexCtrl extends  Fms {
    public function index()
    {
        \Core\Lib\Conf::get('CTRL', 'Route');
        $this->assign('name', '你妹');
        $this->display('index');
    }
}