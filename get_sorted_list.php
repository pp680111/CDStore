<?php
    require_once('CDStore_fns.php');
    $result = get_sorted_list($_REQUEST['option']);
    echo json_encode($result);
?>