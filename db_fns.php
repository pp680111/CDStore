<?php
    function get_db_connection()
    {
        $dbh = null;
        try{
            $dbh = new PDO('mysql:host=localhost;dbmane=cdstore','root','dante123');
        }catch(PDOException $e)
        {
            return '创建数据库连接时发生错误';
        }
        
        return $dbh;
    }
?>