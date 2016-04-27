<?php
// Autoload
require_once(dirname(__FILE__) . '/../vendor/autoload.php');

// APP Environment
define('APP_ENV', (getenv('APP_ENV') ? getenv('APP_ENV') : 'production'));

// Error handling
ini_set('display_errors' , (APP_ENV == 'development'));

// DOTENV INIT
$env = new Dotenv\Dotenv(dirname(__FILE__) . '/config/', '.env.' . APP_ENV);
$env->load();

// SLIM INIT
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim(array(
    'mode' => APP_ENV,
    'debug' => (APP_ENV == 'development')
));
$app->setName(getenv('APP_NAME'));

// SLIM Middlewares INIT
$app->view(new \JsonApiView());
$app->add(new \JsonApiMiddleware());
$app->add(new \App\Middleware\Jwt\JwtAuth(array(
    'secret' => getenv('AUTH_KEY'),
    'secure' => true,
    'relaxed' => array('localhost'),
    'rules' => array(
        new \App\Middleware\Jwt\RequestPathRule(array(
            'path' => '/api/',
            'passthrough' => array('/api/token')
        )),
        new \Slim\Middleware\JwtAuthentication\RequestMethodRule(array(
            'passthrough' => array('GET')
        ))
    )
)));

// DB ELOQUENT INIT
$settings = array(
    'driver' => 'mysql',
    'host' => getenv('DB_HOST'),
    'database' => getenv('DB_NAME'),
    'username' => getenv('DB_USER'),
    'password' => getenv('DB_PASS'),
    'charset' => 'utf8',
    'collation' => 'utf8_general_ci',
    'options' => array(
        \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
    ),
    'prefix' => ''
);

$db = new \Illuminate\Database\Capsule\Manager();
$db->addConnection($settings);
$db->setEventDispatcher(new \Illuminate\Events\Dispatcher(new \Illuminate\Container\Container));
$db->setAsGlobal();
$db->bootEloquent();
