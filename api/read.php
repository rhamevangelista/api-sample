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

    //call car model
    $model = new Car($db);

    $data = $model->getAll();
    $dataCount = $data->rowCount();

    if($dataCount > 0){

        $carAr["data"] = array();
        $carAr["totalRecord"] = $dataCount;

        while ($row = $data->fetch(PDO::FETCH_ASSOC)){
            $arr = FieldGenerator::generateField($row);
            $carAr["data"][] = $arr;
        }
        echo json_encode($carAr);
    } else {
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
