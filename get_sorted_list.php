<?php
    require_once('CDStore_fns.php');
    $result = get_sorted_list($_REQUEST['option'],$_REQUEST['page_index'],$_REQUEST['page_size']);
    echo json_encode($result);
?>