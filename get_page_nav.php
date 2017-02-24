<?php
    require_once('CDStore_fns.php');
    $retValue = array();
    $db = get_db_connection();
    $stmt = $db -> query('select count(*) from cd_list');
    $cd_num = ($stmt->fetch())[0];

    if($_REQUEST['page_index'] == 0)
        $retValue[] = "<li class='disabled'><span aria-hidden='true'>&laquo;</span></li>";
    else $retValue[] = "<li><span aria-hidden='true'>&laquo;</span></li>";

    for($i = 0;$i <= intval($cd_num / $_REQUEST['page_size']);$i++)
    {
        if($i == $_REQUEST['page_index'])
            $retValue[] = "<li class='active'><span>$i</span></li>";
        else $retValue[] = "<li><span>$i</span></li>";
    }

    if($_REQUEST['page_index'] == intval($cd_num / $_REQUEST['page_size']))
        $retValue[] = "<li class='disabled'><span aria-hidden='true'>&raquo;</span></li>";
    else $retValue[] = "<li><span aria-hidden='true'>&raquo;</span></li>";

    echo json_encode($retValue);
?>