<?php

namespace Core\Lib;

class Conf {

    public static $config = [];

    /**
     * 获取配置方法.
     *
     * @param string $name 配置名.
     * @param string $file 配置文件.
     *
     * @return mixed
     * @throws \Exception
     */
    static public function get($name, $file) {
        $conf = self::all($file);
        // 获取配置.
        if (isset($conf[$name])) {
            return $conf[$name];
        }
        throw new \Exception('配置不存在');
    }

    /**
     * 加载文件全部配置.
     *
     * @param string $file 文件地址.
     *
     * @return mixed
     * @throws \Exception
     */
    public static function all($file = '')
    {
        $file = FMS_CORE . '/Config/' . $file . '.php';
        // 加载配置.
        if (isset(self::$config[$file])) {
            $conf = self::$config[$file];
        } else {
            if (is_file($file)) {
                $conf = include $file;
                self::$config[$file] = $conf;
            } else {
                throw new \Exception('配置文件不存在');
            }
        }

        return $conf;
    }
}