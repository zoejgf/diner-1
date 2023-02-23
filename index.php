<?php

// order1 route -> views/order-form1.html
// summary route -> views/order-summary.html

//This is my controller

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require file
require_once('vendor/autoload.php');
require_once('model/data-layer.php');
require_once('model/validate.php');
//require_once('classes/order.php');

//Start a session AFTER requiring autoload.php
session_start();
///var_dump($_SESSION);

/*
$myOrder = new Order();
$myOrder->setFood("tacos");
$myOrder->setMeal("breakfast");
$myOrder->setCondiments("Ketchup, Honey Mustard, Ranch");

echo $myOrder->getFood(), $myOrder->getMeal(), $myOrder->getCondiments();

var_dump($myOrder);
*/
/*
$food1 = "tacos";
$food2 = "";
$food3 = "x";
echo validFood($food1) ? "valid" : "not valid";
echo validFood($food2) ? "valid" : "not valid";
echo validFood($food3) ? "valid" : "not valid";
*/
//var_dump(getMeals());
//var_dump(getCondiments());

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

        $newOrder = new Order();

        //Move food from POST array to SESSION array
        $food = trim($_POST['food']);
        if(validFood($food)) {
            $newOrder->setFood($food);
        } else {
            $f3->set('errors["food"]', 'Food must have at least two characters');
        }

        //validate the meal
        $meal = $_POST['meal'];
        if (validMeal($meal)) {
            $newOrder->setMeal($meal);
        } else {
            $f3->set('errors["meal"]', 'Meal is invalid');
        }

        //Redirect to summary page
        //if there are no errors
        if (empty($f3->get('errors'))) {
            $_SESSION['newOrder'] = $newOrder;
            $f3->reroute('order2');
        }
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
        /*
        $newOrder = $_SESSION['newOrder'];
        $condString = implode(", ",$_POST['conds']);
        $newOrder->setCondiments($condString);
        $_SESSION['newOrder'] = $newOrder;
        */

        $condString = implode(", ",$_POST['conds']);
        $_SESSION['newOrder']->setCondiments($condString);

        //$_SESSION['conds'] = implode(", ",$_POST['conds']);

        //Redirect to summary page
        $f3->reroute('summary');
    }

    //Add condiments to the hive
    $f3->set('condiments', getCondiments());

    //Instantiate a view
    $view = new Template();
    echo $view->render("views/order-form2.html");

});

//Define a summary route (328/diner/summary)
$f3->route('GET /summary', function() {

    //Instantiate a view
    $view = new Template();
    echo $view->render('views/order-summary.html');

    //Destroy session array
    session_destroy();

});

//1. Help each other get caught up
//2. Define a lunch route + page
//3. Add an image to breakfast and/or lunch


//Run Fat Free
$f3->run();
