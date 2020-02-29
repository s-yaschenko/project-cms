<?php

use App\Config;
use App\Di\Container;
use App\Http\Request;
use App\Http\Response;
use App\Http\Session;
use App\Kernel;
use App\MySQL\ArrayDataManager;
use App\MySQL\Connection;
use App\MySQL\Interfaces\IArrayDataManager;
use App\MySQL\Interfaces\IConnection;
use App\MySQL\Interfaces\IObjectDataManager;
use App\MySQL\ObjectDataManager;
use App\QueryBuilder\Interfaces\IQueryBuilder;
use App\QueryBuilder\QueryBuilder;
use App\Renderer\IRenderer;
use App\Renderer\SmartyRenderer;
use App\Service\FlashMessageService;
use App\Service\UserService;

define('APP_DIR', __DIR__ . '/../');

require_once APP_DIR . '/vendor/autoload.php';

session_start();

$container = new Container([
    IConnection::class => Connection::class,
    IArrayDataManager::class => ArrayDataManager::class,
    IObjectDataManager::class => ObjectDataManager::class,
    IQueryBuilder::class => QueryBuilder::class,
    IRenderer::class => SmartyRenderer::class
]);

$container->add(Session::class);
$container->add(Request::class);
$container->add(Response::class);
$container->add(ArrayDataManager::class);
$container->add(ObjectDataManager::class);
$container->add(QueryBuilder::class);
$container->add(UserService::class);
$container->add(FlashMessageService::class);

$container->add(Config::class, function () {
    $config_path = APP_DIR . '/config/config.php';
    $default_configs_path = APP_DIR . '/config.d';

    return new Config($config_path, $default_configs_path);
});

$container->add(Connection::class, function () use ($container) {
    /**
     * @var Config $config
     */
    $config = $container->get(Config::class);
    $host = (string) $config->get('db.host');
    $user = (string) $config->get('db.user');
    $user_password = (string) $config->get('db.password');
    $db_name = (string) $config->get('db.db_name');

    return new Connection($host, $db_name, $user, $user_password);
});

$container->add(Smarty::class, function () use ($container) {
    /**
     * @var Config $config
     */
    $config = $container->get(Config::class);
    $smarty = new Smarty();

    $smarty->template_dir = $config->get('template.template_dir');
    $smarty->compile_dir = $config->get('template.compile_dir');
    $smarty->cache_dir = $config->get('template.cache_dir');

    return $smarty;
});

/**
 * @var Kernel $kernel
 */

$kernel = $container->get(Kernel::class);


