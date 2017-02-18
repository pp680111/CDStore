<?php
    require_once('CDStore_fns.php');
    session_start();

    function get_cd_list()
    {
        $dbh = get_db_connection();
        if(!$dbh)
        {
            echo '创建数据库连接时发生错误';
            die();
        }    
        
        $stmt = $dbh->prepare('select * from cd_list');
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;

    }

    function get_cd()
    {
        
    }
?>