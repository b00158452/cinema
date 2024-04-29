<?php

class Conection{

    public static function ConectionDB(){
        $host = 'localhost';
        $dbname = 'cinema';
        $username = 'root';
        $password = 'root';

        try{
            $conn = new PDO ("mysql:host=$host;dbname=$dbname", $username, $password);


        }catch(PDOException $exp){
            echo("Could not connect to the database: $dbname, error: $exp");
            echo "<br>";
        }

        return $conn;
    }
}

?>
