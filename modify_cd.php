<?php 
    require_once('CDStore_fns.php');
    
    $db = get_db_connection();
    $db->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $modify_data = array();
    $sql = 'update cd_list set ';
    try{
        $db->beginTransaction();

        //获取原版数据，和提交的数据进行对比，如果不一样的话就在存进modify数组里
        $orig_data = get_cd_detail($_POST['cd_id']);
        $sql = 'update cd_list set ';
        if($orig_data['name'] != $_POST['name'])
            $modify_data['name'] = $_POST['name'];
        if($orig_data['artist'] != $_POST['artist'])
            $modify_data['artist'] = $_POST['artist'];
        if($orig_data['amount'] != $_POST['amount'])
            $modify_data['amount'] = $_POST['amount'];
        if($orig_data['presentation'] != $_POST['presentation'])
            $modify_data['presentation'] = $_POST['presentation'];
        
        if(count($modify_data) != 0)
        {
             //借助关联数组的key来拼接sql查询字符串
            foreach($modify_data as $key => $value)
                $sql .= $key . '=?,';
            $sql = substr($sql,0,-1);
            $sql .=' where id=' . $_POST['cd_id'];
            $stmt = $db->prepare($sql);
            $i = 1;
            foreach($modify_data as $$value)
                $stmt->bindParam($i++,$value);
                
            if(!$stmt->execute())
                throw new PDOException('更新专辑数据失败');
        }
        
        //这里我还是直接删了歌曲信息在插进去吧。。。
        $db->exec('delete from song_list where cd_id='.$_POST['cd_id']);

        $sql = 'insert into song_list(name,artist,cd_id) values';
        for($i = 0;$i < count($_POST['song_name']) - 1;$i++)
            $sql .= "(?,?,{$_POST['cd_id']}),";
        $sql .= "(?,?,{$_POST['cd_id']})";

        $stmt = $db->prepare($sql);
        for($i = 1;$i <= count($_POST['song_name']);$i++)
        {
            $stmt->bindParam(($i * 2 - 1),$_POST['song_name'][$i - 1]);
            $stmt->bindParam($i * 2,$_POST['song_artist'][$i - 1]);
        }

        if(!$stmt->execute())
            throw new PDOException('更新歌曲列表数据失败');
       
        $db->commit();
    }
    catch(PDOException $e)
    {   
        //输出错误数据
        $retValue['message'] = $e->getMessage();
        $retValue['status'] = 'failed';
        echo json_encode($retValue);
        $db->rollback();
        exit;
    }

    $db -> setAttribute(PDO::ATTR_AUTOCOMMIT,1);

    if($_FILES['cover']['error'] != UPLOAD_ERR_NO_FILE)
    {
        if(($validate_result = cover_img_validate($_FILES['cover'])) !== true)
        {
            $retValue['status'] = 'failed';
            $retValue['message'] = $validate_result;
            echo json_encode($retValue);
            exit;
        }

        //使用is_uploaded_file和move_uploaded_file函数来操作上传的文件，目的是为了安全，这两个函数会检查传入的参数是不是通过表单上传的文件
        if(is_uploaded_file($_FILES['cover']['tmp_name']))
        {
            if(!move_uploaded_file($_FILES['cover']['tmp_name'],'static/img/cover/'.$_POST['cd_id'].'.jpg'))
            {
                $retValue['status'] = 'failed';
                $retValue['message'] = '无法保存封面文件';
                echo json_encode($retValue);
                exit;
            }
        }
        else{
            $retValue['status'] = 'failed';
            $retValue['message'] = '封面文件是非法文件';
            echo json_encode($retValue);
            exit;
        }
    }

    $retValue['status'] = 'success';
    $retValue['message'] = '唱片数据更新成功';
    echo json_encode($retValue);
    
?>