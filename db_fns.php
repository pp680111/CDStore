<?php
    function get_db_connection()
    {
        $dbh = null;
        try{
            $dbh = new PDO('mysql:host=localhost:3306;dbname=cdstore','root','dante123');
        }catch(PDOException $e)
        {
            return false;
        }
        
        return $dbh;
    }
?>