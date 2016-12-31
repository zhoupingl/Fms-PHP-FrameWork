<?php

namespace Core\Lib;

class Route
{

    public $ctrl;
    public $action;

    public function __construct()
    {
        if (!isset($_SERVER['REQUEST_URI'])) {
            $_SERVER['REQUEST_URI'] = '/';
        }

        // 加载默认路由配置.
        $this->ctrl = 'index';
        $this->action = 'index';
        if (!empty(Conf::get('CTRL', 'Route'))) {
            $this->ctrl = Conf::get('CTRL', 'Route');
        }
        if (!empty(Conf::get('ACTION', 'Route'))) {
            $this->action = Conf::get('ACTION', 'Route');
        }

        // 分析RRI路径.
        if ($_SERVER['REQUEST_URI'] != '/') {
            list($ctrl, $action, $params) = FMS_explode('/', trim($_SERVER['REQUEST_URI'], '/'), 3);
            $params = trim($params, '/');
            if (!empty($ctrl)) {
                $this->ctrl = $ctrl;
            }
            if (!empty($action)) {
                $this->action = $action;
            }

            // 处理URI GET参数.
            if (!empty($params)) {
                $params = explode('/', $params);
                $count = count($params);
                if ($count % 2 != 0) {
                    $params[$count] = NULL;
                }
                for ($i = 0; $i < $count; $i += 2) {
                    $_GET[$params[$i]] = $params[$i + 1];
                }
            }
        }
        $this->ctrl = ucfirst(strtolower($this->ctrl));
        $this->action = strtolower($this->action);
    }
}