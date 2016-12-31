<?php
//echo 'Hello word!';

define('FMS_ROOT', __DIR__);
define('FMS_CORE', FMS_ROOT . '/Core');
define('FMS_APP', FMS_ROOT . '/App');
define('FMS_CACHE', FMS_APP . '/Cache');
define('FMS_VIEW', FMS_APP . '/View');
define('FMS_TWIG', false);
define('FMS_MODULE', 'App');
define('FMS_DEBUG', true);

// composer 自动加载.
include  FMS_ROOT . '/vendor/autoload.php';

// 处理异常.
if (FMS_DEBUG) {
    $whoops = new \Whoops\Run();
    $prettyPageHandler = new \Whoops\Handler\PrettyPageHandler();
    $title = '异常';
    $prettyPageHandler->setPageTitle($title);
    $whoops->pushHandler($prettyPageHandler);
    $whoops->register();
    ini_set('display_errors', 'On');
} else {
    ini_set('display_errors', 'Off');
}

// 引入库.
include FMS_CORE . '/Common' . '/Function.php';
include FMS_CORE . '/Fms.php';
spl_autoload_register('\Core\Fms::load');
// RUN.
\Core\Fms::run();

