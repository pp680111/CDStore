<?php 
    require_once('header.php');
    require_once('CDStore_fns.php');
    $cd_detail = get_cd_detail($_REQUEST['id']);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1 content">
            <div class="detail">
                <ul class="detail_layout">
                    <li>
                        <h4>专辑封面</h4>
                        <img src="static/img/<?php echo $cd_detail['id'] ?>.jpg" alt="图片缺失" width="200px" height="200px">
                    </li>
                    <li>
                        <h4>专辑名</h4>
                        <h4><?php echo $cd_detail['name'] ?></h4>
                    </li>
                    <li>
                        <h4>艺术家</h4>
                        <h4><?php echo $cd_detail['artist'] ?></h4>
                    </li>
                    <li>
                        <h4>介绍</h4>
                        <p><?php echo $cd_detail['presentation'] ?></p>
                    </li>
                    <li>
                        <h4>当前库存量</h4>
                        <h4><?php echo $cd_detail['amount'] ?></h4>
                    </li>
                    <li>
                        <h4>曲目列表</h4>
                        <table class="table" id="song_table">
                            <thead>
                                <th>曲目顺序</th>
                                <th>曲名</th>
                                <th>艺术家</th>
                            </thead>
                            <tbody>
                                <?php
                                    $count = 1;
                                    foreach($cd_detail['song_list'] as $song)
                                    {
                                        echo '<tr>';
                                        echo '<td>' . $count++ . '</td>';
                                        echo '<td>' . $song['name'] . '</td>';
                                        echo '<td>' . $song['artist'] . '</td>';
                                        echo '<tr/>';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script src="../static/js/jquery-3.1.1.min.js"></script>
<script src="../static/js/bootstrap.min.js"></script>
<script>

</script>
<?php require_once('footer.php'); ?>
