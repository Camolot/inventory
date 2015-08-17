<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Inventory.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=inventory';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('candies' => Inventory::getAll()));
    });

    $app->get("/candies", function() use ($app) {
        return $app['twig']->render('candies.html.twig', array('candies' => Inventory::getAll()));
    });

    $app->post("/candies", function() use ($app) {
        $candy = new Inventory($_POST['name']);
        $candy->save();
        return $app['twig']->render('candies.html.twig', array('candies' => Inventory::getAll()));
    });

    $app->post("/delete_candy", function() use ($app) {
        Inventory::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    return $app;

 ?>
