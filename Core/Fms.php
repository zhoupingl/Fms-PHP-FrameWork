<?php

namespace Core;

class Fms
{
    /**
     * $classMap 标记已经加载的类，如果已经加载则不再加载类文件.
     * $assigns  变量数据.
     * @var array $classMap
     * @var array $assigns
     */
    public static $classMap = [];
    public $assigns = [];

    // 入口.
    public static function run()
    {
        $route = new \Core\Lib\Route();
        $filePath = FMS_APP . '/Ctrl/' . $route->ctrl . 'Ctrl.php';
        $class = "\\" . FMS_MODULE . "\\" . "Ctrl\\" . $route->ctrl . "Ctrl";

        // 加载控制器.
        if (!isset(self::$classMap[$class])) {
            if (file_exists($filePath)) {
                include $filePath;
                self::$classMap[$class] = $class;
            } else {
                throw new \Exception('没有找到控制器');
            }
        }

        // 调用控制器.
        $object = new $class;
        if (!method_exists($class, $route->action)) {
            throw new \Exception('没有找到控制器方法');
        }
        call_user_func([$object, $route->action]);
    }

    // 自动加载类文件.
    public static function load($class)
    {
        $class = str_replace("\\", '/', $class);
        $path = realpath(FMS_ROOT . '/' . $class . '.php');
        if (is_file($path)) {
            if (!isset(self::$classMap[$class])) {
                self::$classMap[$class] = $class;
                include $path;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * 将值传递给视图.
     *
     * @param mixed $name  KEY.
     * @param mixed $value VALUE.
     *
     * @return void
     */
    public function assign($name, $value)
    {
        $this->assigns[$name] = $value;
    }

    /**
     * 调用视图模板.
     *
     * @param string $file    文件地址.
     * @param array  $assigns 数据.
     *
     * @return void
     */
    public function display($file, $assigns = [])
    {
        if (!empty($assigns) && is_array($assigns)) {
            foreach ($assigns as $name => $assign) {
                $this->assign($name, $assign);
            }
        }

        // Twig模板.
        $loader = new \Twig_Loader_Filesystem(FMS_APP . '/View');
        $twig = new \Twig_Environment($loader, array(
            'cache' => FMS_CACHE,
            'debug' => FMS_DEBUG,
        ));
        echo $twig->render($file . '.php', !empty($this->assigns) ? $assigns : []);
    }
}