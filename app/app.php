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
///////////////
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
    $app->get('/store/{id}', function($id) use($app){
        $store = Store::find($id);
        $store_brands = $store->getBrands();

        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $store_brands));
    });

    $app->post('/store_add_brand/{id}', function($id) use($app){
        $store = Store::find($id);
        $name = $_POST['name'];
        $new_brand = new Brand($name);
        $new_brand->save();
        $store->addBrand($new_brand);
        $store_brands = $store->getBrands();

        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $store_brands));
    });

    $app->post('/delete_store_brands/{id}', function($id) use($app){
        $store = Store::find($id);
    // Only delete brands in this store
        foreach($store->getBrands() as $shoe){
            $shoe->delete();
        }
        $store_brands = $store->getBrands();

        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $store_brands));
    });
// update and delete routes for store
    $app->get('/edit_store/{id}', function($id) use($app){
        $store = Store::find($id);

        return $app['twig']->render('store_edit.html.twig', array('store' => $store));
    });
    $app->patch('/edit_store', function() use($app){
        $id = $_POST['id'];
        $store = Store::find($id);
        $new_name = $_POST['name'];
        $store->update($new_name);
        $store_brands = $store->getBrands();

        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $store_brands));
    });

    $app->delete('/delete_store', function() use($app){
        $id = $_POST['id'];
        $store = Store::find($id);
        $store->delete();

        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });
////////////////
// All brands routes

    $app->get('/brands', function() use($app){

        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll()));
    });

    $app->post('/add_brand', function() use($app){
        $name = $_POST['name'];
        $new_brand = new Brand($name);
        $new_brand->save();

        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll()));
    });

    $app->post('/delete_all_brands', function() use($app){
        Brand::deleteAll();

        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll()));
    });

// add and delete stores to brand
    $app->post('/brand_add_store', function() use($app){
        $brand = Brand::find($_POST['brand_id']);
        $store = Store::find($_POST['store_id']);
        $brand->addStore($store);

        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll()));
    });

    $app->post('/brand_drop_store', function() use($app){
        $brand = Brand::find($_POST['brand_id']);
        $store = Store::find($_POST['store_id']);
        $brand->dropStore($store);

        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll()));

    });



// update and delete routes for brand
    $app->get('/edit_brand/{id}', function($id) use($app){
        $brand = Brand::find($id);

        return $app['twig']->render('brand_edit.html.twig', array('brand' => $brand, 'stores' => Store::getAll()));
    });
    $app->patch('/edit_brand', function() use($app){
        $id = $_POST['id'];
        $brand = Brand::find($id);
        $new_name = $_POST['name'];
        $brand->update($new_name);

        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll()));
    });

    $app->delete('/delete_brand', function() use($app){
        $id = $_POST['id'];
        $brand = Brand::find($id);
        $brand->delete();

        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll()));
    });

        return $app;
?>
