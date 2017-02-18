<?php include_once("header.php"); ?>
<?php include_once('CDStore_fns.php'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1 content">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#cd_list" data-toggle="tab">CD列表</a></li>
                <li><a href="#sales_log" data-toggle="tab">销售记录</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active list" id="cd_list">
                    <button class="btn btn-default addCD"><a href="/view/addCD.html">添加新CD</a></button>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>名称</th>
                                <th>艺术家</th>
                                <th>介绍</th>
                                <th>库存数量</th>
                                <th>创建时间</th>
                                <th>最后修改信息时间</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $cd_list = get_cd_list();
                                foreach ($cd_list as $row) {
                                    echo '<tr>';
                                    echo "<td>" . $row['id'] . '</td>';
                                    echo "<td><a href='cd_detail.php'>" . $row['name'] . '</a></td>';
                                    echo '<td>' . $row['artist'] . '</td>';
                                    echo '<td>' . $row['presentation'] . '</td>';
                                    echo '<td>' . $row['amount'] . '</td>';
                                    echo '<td>' . $row['create_time'] . '</td>';
                                    echo '<td>' . $row['update_time'] . '</td>';
                                    echo '<td>' . '占空' . '</td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="sales_log">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../static/js/jquery-3.1.1.min.js"></script>
<script src="../static/js/bootstrap.min.js"></script>
<?php include_once("footer.php");?>