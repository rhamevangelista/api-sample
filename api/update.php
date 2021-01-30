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

    //check if id is isset
    if(!isset($_POST['id']) && !is_numeric($_POST['id']) && $_POST['id'] == 0){
        $errorArr['id'] = "Id is required.";
    }

    //check if name is isset
    if(!isset($_POST['name']) && trim($_POST['name']) == ''){
        $errorArr['name'] = "Name is required.";
    }

    //check if type is isset
    if(!isset($_POST['type']) && trim($_POST['type']) == ''){
        $errorArr['type'] = "Type is required.";
    }

    //check if brand is isset
    if(!isset($_POST['brand']) && trim($_POST['brand']) == ''){
        $errorArr['brand'] = "Brand is required.";
    }

    //check if year is isset
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

    $model->id = (int)$_POST['id'];
    $model->model_name = htmlspecialchars($_POST['name']);
    $model->model_type = htmlspecialchars($_POST['type']);
    $model->model_brand = htmlspecialchars($_POST['brand']);
    $model->model_year = (int)$_POST['year'];

    
    if($model->update()){
        echo json_encode(
            array("message" => "Car successfully updated.")
        );
    } else{
        echo json_encode(
            array("message" => "Error: Cannot be updated.")
        );
    }