<?php
    class Car{

        private $conn;
        private $table = "model";

        public $id;
        public $model_name;
        public $model_type;
        public $model_brand;
        public $model_year;
        public $model_date_added;

        public function __construct($db){
            $this->conn = $db;
        }

        //get all records
        public function getAll(){
            $query = "SELECT `id`, `model_name`, `model_type`, `model_brand`, `model_year`, `model_date_added`, `model_date_modified` FROM " . $this->table;
            $data = $this->conn->prepare($query);
            $data->execute();
            return $data;
        }

        // Read single record method
        public function getSingle(){
            $query = "SELECT `id`, `model_name`, `model_type`, `model_brand`, `model_year`, `model_date_added`, `model_date_modified` FROM " . $this->table ." WHERE id = ? LIMIT 0,1";

            $data = $this->conn->prepare($query);

            $data->bindParam(1, $this->id);

            $data->execute();

            $dataRow = $data->fetch(PDO::FETCH_ASSOC);
            
            $this->id = $dataRow['id'];
            $this->model_name = $dataRow['model_name'];
            $this->model_type = $dataRow['model_type'];
            $this->model_brand = $dataRow['model_brand'];
            $this->model_year = $dataRow['model_year'];
            $this->model_date_added = $dataRow['model_date_added'];
        }        


        // Create record method
        public function create(){
            $query = "INSERT INTO ". $this->table ." SET model_name = :model_name, model_type = :model_type, model_brand = :model_brand, model_year = :model_year, model_date_added = :model_date_added";
        
            $data = $this->conn->prepare($query);
        
            $data->bindParam(":model_name", $this->model_name);
            $data->bindParam(":model_type", $this->model_type);
            $data->bindParam(":model_brand", $this->model_brand);
            $data->bindParam(":model_year", $this->model_year);
            $data->bindParam(":model_date_added", $this->model_date_added);
        
            if($data->execute()){
               return true;
            }
            return false;
        }

        
        // Update record method
        public function update(){
            $query = "UPDATE ". $this->table ." SET model_name = :model_name, model_type = :model_type, model_brand = :model_brand, model_year = :model_year WHERE id = :id";
        
            $data = $this->conn->prepare($query);

            $data->bindParam(":model_name", $this->model_name);
            $data->bindParam(":model_type", $this->model_type);
            $data->bindParam(":model_brand", $this->model_brand);
            $data->bindParam(":model_year", $this->model_year);
            $data->bindParam(":id", $this->id);
        
            if($data->execute()){
               return true;
            }
            return false;
        }

        // Delete record method
        function delete(){
            //check id if exists
            $query = "SELECT * FROM " . $this->table ." WHERE id = ?";
            $data = $this->conn->prepare($query);
            $data->bindParam(1, $this->id);
            $data->execute();
            $row = $data->fetch(PDO::FETCH_ASSOC);
            if(!$row){
                return false;
            } else {
                //process delete
                $query = "DELETE FROM " . $this->table . " WHERE id = ?";
                $data = $this->conn->prepare($query);
            
                $data->bindParam(1, $this->id);
            
                if($data->execute()){
                    return true;
                }
                return false;
            }
                
        }

    }
?>