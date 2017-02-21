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
                    <a href="add_cd.html" class="btn btn-default addCD">添加新CD</a>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>名称</th>
                                <th>艺术家</th>
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
                                    echo "<td><a href='cd_detail.php?id={$row['id']}'>" . $row['name'] . '</a></td>';
                                    echo '<td>' . $row['artist'] . '</td>';
                                    echo '<td>' . $row['amount'] . '</td>';
                                    echo '<td>' . $row['create_time'] . '</td>';
                                    echo '<td>' . $row['update_time'] . '</td>';
                                    echo '<td>' . "<a href='#' onclick='delete_cd({$row['id']})'>删除</a>&emsp;<a href='modify_cd.html?cd_id={$row['id']}'>修改</a></td>";
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
<!-- modal -->
<div class="modal fade" role="dialog" id="delete_cd_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
                <h4 class="modal-title" >确认删除该唱片的信息？</h4>
            </div>
            <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭
				</button>
				<button type="button" class="btn btn-primary" id="confirm_delete">
					确认
				</button>
			</div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="message">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
                <h4 class="modal-title" id="message_title"></h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="message_confirm">关闭</button>
            </div>
        </div>
    </div>
</div>
<!-- modal end -->
<script src="../static/js/jquery-3.1.1.min.js"></script>
<script src="../static/js/bootstrap.min.js"></script>
<script>
    function delete_cd(id)
    {
        $("#delete_cd_modal").modal('show');
        $("#confirm_delete").click(function(){
            $.ajax({
                url:'delete_cd.php',
                type:'post',
                data:{cd_id:id},
                dataType:'json',
                success:function(data){
                    if(data.status == 'success')
                    {
                        $("#message").modal('show');
                        $("#message_title").text('删除成功');
                        $("#message_confirm").click(function(){location.reload()});
                    }
                    else{
                        $("#message").modal('show');
                        $("#message_title").text('删除失败');
                        $("#message_confirm").click(function(){location.reload()});
                    }
                },
                error:function(){
                    alert('删除请求出错了');
                }
            });
        });
    }
</script>
<?php include_once("footer.php");?>