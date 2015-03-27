<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Brand.php";
    require_once __DIR__."/../src/Store.php";

    $app = new Silex\Application();
    $app['debug'] = true;

    $DB = new PDO('pgsql:host=localhost;dbname=shoes');

    $app->register(new Silex\Provider\TwigServiceProvider(),
        array('twig.path'=>__DIR__.'/../views'));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodparameterOverride();
// Home Page
    $app->get('/', function() use($app){

        return $app['twig']->render('index.html.twig');
    });

// All stores routes
    $app->get('/stores', function() use($app){

        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    $app->post('/add_store', function() use($app){
        $name = $_POST['name'];
        $new_store = new Store($name);
        $new_store->save();

        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    $app->post('/delete_all_stores', function() use($app){
        Store::deleteAll();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });
// Single Store Routes



    return $app;
 ?>
