<?php
    function add_cd_validate($data)
    {
        if(strlen($data['name']) == 0 || strlen($data['name']) > 255)
            return '专辑名称长度应大于0小于255个字符';
        if(strlen($data['artist']) == 0 || strlen($data['artist']) > 255)
            return '艺术家名称长度应大于0小于255个字符';
        if(!is_numeric($data['amount']))
            return '库存数请输入一个整数';
        for($i = 0;$i < count($data['song_name']) ;$i++)
        {
            if(strlen($data['song_name'][$i]) == 0 || strlen($data['song_name'][$i]) > 255)
                return '曲目名称程度应大于0小于255个字符';
            if(strlen($data['song_artist'][$i]) == 0 || strlen($data['song_artist'][$i]) > 255)
                return '曲目艺术家名称程度应大于0小于255个字符';
        }

        return true;
    }

    function cover_img_validate($data)
    {
        if($data['error'] > 0)
            return '封面图片上传发生错误';
        if(!($data['type'] == 'image/jpeg' || $data['type'] == 'image/png'))
            return '文件类型错误，请选择png或jpg图片';
        return true;
    }
?>