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

    function get_recommend_list()
    {
        $dbh = get_db_connection();
        $stmt = $dbh -> query('select id from cd_list order by rand() limit 5');
        return $stmt -> fetchAll(PDO::FETCH_NUM);
    }

    function get_sorted_list($option,$page_index,$page_size)
    {
        $db = get_db_connection();
        if(!empty($option))
            $stmt = $db -> query('select * from cd_list order by ' . $option . ' asc limit ' . $page_index * $page_size . ',' . $page_size);
        else $stmt = $db -> query('select * from cd_list limit ' . $page_index * $page_size . ',' . $page_size);
        $result = $stmt->fetchAll(PDO::FETCH_NAMED);
        //顺便计算一下总页数，处理如何显示分页导航的任务就交给jquery了，减轻服务端的计算量

        $stmt = $db -> query('select count(*) from cd_list');
        $cd_num = ($stmt->fetch())[0];
        array_push($result,array('page_num'=>intval($cd_num / $page_size)));

        return $result;
    }
?>
