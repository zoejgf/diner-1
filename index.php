<?php

// order1 route -> views/order-form1.html
// summary route -> views/order-summary.html

//This is my controller

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

//Require file
require_once('vendor/autoload.php');
require_once('model/data-layer.php');
//var_dump(getMeals());

//Instantiate F3 Base class
$f3 = Base::instance();

//Define a default route (328/diner)
$f3->route('GET /', function() {

    //Instantiate a view
    $view = new Template();
    echo $view->render("views/diner-home.html");

});

//Define a breakfast route (328/diner/breakfast)
$f3->route('GET /breakfast', function() {

    //Instantiate a view
    $view = new Template();
    echo $view->render("views/breakfast.html");

});

//Define an order1 route (328/diner/order1)
$f3->route('GET|POST /order1', function($f3) {

    //var_dump($_POST);
    //["food"]=> string(5) "pizza" ["meal"]=> string(9) "breakfast" }


    //If the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Move data from POST array to SESSION array
        $_SESSION['food'] = $_POST['food'];
        $_SESSION['meal'] = $_POST['meal'];

        //Redirect to summary page
        $f3->reroute('order2');
    }

    //add meals to F3 hive
    $f3->set('meals', getMeals());

    //Instantiate a view
    $view = new Template();
    echo $view->render('views/order-form1.html');

});

//Define an order2 route (328/diner/order2)
$f3->route('GET|POST /order2', function($f3) {

    //If the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Move data from POST array to SESSION array
        $_SESSION['conds'] = implode(", ",$_POST['conds']);

        //Redirect to summary page
        $f3->reroute('summary');
    }
    $f3->set('condiments', getCondiments());

    //Instantiate a view
    $view = new Template();
    echo $view->render('views/order-form2.html');

});

//Define a summary route (328/diner/summary)
$f3->route('GET /summary', function() {

    //Instantiate a view
    $view = new Template();
    echo $view->render('views/order-summary.html');

});

//1. Help each other get caught up
//2. Define a lunch route + page
//3. Add an image to breakfast and/or lunch


//Run Fat Free
$f3->run();
