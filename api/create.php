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

    //instantiate database connection
    $database = new Database(HOST, DB, USER, PASSWORD);
    $db = $database->getConnection();

    $model = new Car($db);

    $errorArr = array();

    //check if name is isset
    if(!isset($_POST['name']) && trim($_POST['name']) == ''){
        $errorArr['name'] = "Name is required.";
    }

    //check if name is isset
    if(!isset($_POST['type']) && trim($_POST['type']) == ''){
        $errorArr['type'] = "Type is required.";
    }

    //check if name is isset
    if(!isset($_POST['brand']) && trim($_POST['brand']) == ''){
        $errorArr['brand'] = "Brand is required.";
    }

    //check if name is isset
    if(!isset($_POST['year']) && trim($_POST['year']) == ''){
        $errorArr['year'] = "Year is required.";
    }

    //output validation errors if any
    if(count($errorArr) > 0){
        echo json_encode(
            array(
                "message" => "Error: Some fields are required.", 
                "required" => $errorArr
            )
        );

        die();
    }

    $model->model_name = htmlspecialchars($_POST['name']);
    $model->model_type = htmlspecialchars($_POST['type']);
    $model->model_brand = htmlspecialchars($_POST['brand']);
    $model->model_year = (int)$_POST['year'];
    $model->model_date_added = date('Y-m-d H:i:s');
    
    if($model->create()){
        echo json_encode(
            array("message" => "Car successfully inserted.")
        );
    } else{
        echo json_encode(
            array("message" => "Error: Cannot be inserted.")
        );
    }