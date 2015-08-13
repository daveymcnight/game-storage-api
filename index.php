<?php
/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$app = new \Slim\Slim();

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */

// GET route

//$db = new PDO(
//    'mysql:host=' . IConnectionInfo::HOST .
//    ';dbname=' . IConnectionInfo::DBNAME .
//    ';charset=utf8',
//    IConnectionInfo::USERNAME,
//    IConnectionInfo::PASSWORD
//);



$db = new PDO(
    'mysql:host=localhost' .
    ';dbname=keeper' .
    ';charset=utf8',
    'root',
   'root'
);

function executeQuery($query){
    global $db;
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    echo json_encode($result);
}


/* SYSTEM */

//get all systems
$app->get(
    '/systems',
    function (){
        $query = "SELECT * from system";
        executeQuery($query);
    }
);



//get system by id
$app->get(
    '/system/:id',
    function ($id) {
        $query = "SELECT name from system WHERE id = $id;";
        executeQuery($query);
    }
);

/* END OF SYSTEM */

$app->get(
    '/games',
    function (){
        $query = "SELECT * from game";
        executeQuery($query);
    }
);



$app->get('/game/:systemid', function($systemid) use($db){
    $query = "SELECT name FROM game WHERE system_id = $systemid";
    executeQuery($query);
});

// POST route
$app->post(
    '/post/system/',
    function () {
        global $app;
        $params= json_decode($app->request->getBody(),true);
        $name = $params['name'];
        $query = "INSERT INTO system (name) VALUES ('" . $name . "')";
        echo $query;
        //executeQuery($query);
    }
);

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
