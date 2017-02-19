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

    function get_cd_detail($id)
    {
        $dbh = get_db_connection();
        if(!$dbh)
        {
            echo '创建数据库连接时发生错误';
            die();
        }

        $stmt = $dbh->prepare('select * from cd_list where id=?');
        $stmt->bindParam(1,$id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $stmt = $dbh->prepare('select * from song_list where cd_id=?');
        $stmt->bindParam(1,$id);
        $stmt->execute();
        $result['song_list'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    
?>