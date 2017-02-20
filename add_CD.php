<?php 
    require_once('CDStore_fns.php');
    
    if(($validate_result = add_cd_validate($_POST)) !== true)
    {
        //显示数据校验错误信息
        echo $validate_result;
        die();
    }
    
    //先将数据插入数据库再保存专辑图片
    $db = get_db_connection();
    $db -> setAttribute(PDO::ATTR_AUTOCOMMIT,0);
    //开启异常处理
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try{
        $db->beginTransaction();
        //先插入cd数据
        $stmt = $db->prepare('insert into cd_list(name,artist,amount,create_time,update_time,presentation) values(?,?,?,?,?,?)');
        $stmt->bindParam(1,$_POST['name']);
        $stmt->bindParam(2,$_POST['artist']);
        $stmt->bindParam(3,$_POST['amount']);
        $stmt->bindParam(4,date('Y-m-d H:i:s',time()));
        $stmt->bindParam(5,date('Y-m-d H:i:s',time()));
        $stmt->bindParam(6,$_POST['presentation']);
        if(!$stmt->execute())
            throw new PDOException('插入cd数据失败');
        
        //后插入歌曲列表数据
        $cd_data = $db->query('select id from cd_list order by create_time desc limit 1');
        $cd_id = ($cd_data->fetch())['id'];

        //这里因为要实现一次性插入多行数据，所以使用了拼接sql语句的方法
        $sql = 'insert into song_list(name,artist,cd_id) values';
        for($i = 0;$i < count($_POST['song_name']) - 1;$i++)
            $sql .= "(?,?,$cd_id),";
        $sql .= "(?,?,$cd_id)";

        $stmt = $db->prepare($sql);
        for($i = 1;$i <= count($_POST['song_name']);$i++)
        {
            $stmt->bindParam(($i * 2 - 1),$_POST['song_name'][$i - 1]);
            $stmt->bindParam($i * 2,$_POST['song_artist'][$i - 1]);
        }

        if(!$stmt->execute())
            throw new PDOException('插入歌曲列表数据失败');

        $db->commit();
    }
    catch(PDOException $e)
    {
        //输出错误数据
        echo $e->getMessage();
        $db->rollback();
    }
    $db -> setAttribute(PDO::ATTR_AUTOCOMMIT,1);

    //保存专辑图片到static/img/cover下面，以专辑id命名

    if(($validate_result = cover_img_validate($_FILES['cover'])) !== true)
    {
        echo $validate_result;
        exit;
    }

    //使用is_uploaded_file和move_uploaded_file函数来操作上传的文件，目的是为了安全，这两个函数会检查传入的参数是不是通过表单上传的文件
    if(is_uploaded_file($_FILES['cover']['tmp_name']))
    {
        if(!move_uploaded_file($_FILES['cover']['tmp_name'],'static/img/cover/'.$cd_id.'.jpg'))
        {
            echo '移动文件错误';
            exit;
        }
    }
    else{
        echo '该文件是非法文件';
    }

?>