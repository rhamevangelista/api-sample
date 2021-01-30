<?php
    //allow or disallow request from different domain
    include('../helpers/Cors.php');

    //configuration file
    require('../env.php');

    //helpers
    include('../helpers/FieldGenerator.php');
    
    //classes
    require('../config/database.php');
    require('../model/Car.php');

    //check if id is set and if numeric and if not equal to zero
    if(isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] != 0){
        $id = $_GET['id'];
    } else {
        http_response_code(404);
        echo json_encode("Car not found.1");

        die();
    }

    //instantiate database connection
    $database = new Database(HOST, DB, USER, PASSWORD);
    $db = $database->getConnection();

    //call car model
    $data = new Car($db);
    $data->id = $id;
    $data->getSingle();

    if($data->model_date_added != NULL){
        $arr = FieldGenerator::generateField($data, 'object');
      
        http_response_code(200);
        echo json_encode($arr);
    } else {
        http_response_code(404);
        echo json_encode("Car not found.");
    }