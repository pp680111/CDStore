<?php
    require_once ('CDStore_fns.php');

    //需要先删除曲目列表中的曲子然后再删掉cd列表中的项，使用事务来执行这个过程
    $db = get_db_connection();
    $db->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
    //开启异常处理
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $retValue = array();
    try{
        $db->beginTransaction();
        $db->exec('delete from song_list where cd_id='.$_POST['cd_id']);
        $db->exec('delete from cd_list where id='.$_POST['cd_id']);
        $db->commit();
        $retValue['status'] = 'success';
    }
    catch(PDOException $e)
    {
        $db->rollback();
        $retValue['status'] = 'error';
    }
    $db->setAttribute(PDO::ATTR_AUTOCOMMIT,1);
    // return var_dump(json_encode($retValue));
    echo json_encode($retValue);
?>