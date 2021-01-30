<?php

class FieldGenerator
{
    public static function generateField($data, $type = 'array')
    {
        if($type == 'array'){
            extract($data);
            $arr = array(
                "id" => $id,
                "model_name" => $model_name,
                "model_type" => $model_type,
                "model_brand" => $model_brand,
                "model_year" => $model_year,
                "model_date_added" => $model_date_added
            );
        } elseif ($type == 'object') {
            $arr = array(
                "id" => $data->id,
                "model_name" => $data->model_name,
                "model_type" => $data->model_type,
                "model_brand" => $data->model_brand,
                "model_year" => $data->model_year,
                "model_date_added" => $data->model_date_added
            );
        }

        return $arr;
    }
}