<?php
    //allow or disallow request from different domain
    include('../helpers/Cors.php');

    //configuration file
    require('../env.php');
    
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
    
    if($model->delete()){
        echo json_encode("Car deleted.");
    } else{
        echo json_encode("Car could not be deleted");
    }