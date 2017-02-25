<?php 
    require_once('CDStore_fns.php');
    session_start();
    if(!isset($_SESSION['total_price']))
        $_SESSION['total_price'] = 0;
    $recommend_list = get_recommend_list();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
    <META HTTP-EQUIV="Expires" CONTENT="0"> 
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <link rel="stylesheet" href="/static/css/myStyle.css">
    <title>Welcome to ZST's CDStore</title>
</head>
<body>  
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1 content">
                <h2>今日推荐</h2>
                <div class="my_slide">
                    <span class="glyphicon glyphicon-backward"></span></section>
	                <span class="glyphicon glyphicon-forward"></span></section>
                    <ul>
                        <?php 
                            foreach($recommend_list as $value)
                            {
                                echo "<li><a href='cd_detail.php?id={$value[0]}'><img src='/static/img/cover/{$value[0]}.jpg' width='300px' height='300px'></a></li>";
                            }
                        ?>
                    </ul>
                </div>

                <div class="row">
                    <div class="col-xs-2">
                        <ul class="list-group order_controll">
                            <li class="list-group-item" id="sort_by_name">按专辑名排序</li>
                            <li class="list-group-item" id="sort_by_artist">按艺术家名排序</li>
                            <li class="list-group-item" id="sort_by_create_time">按上架时间排序</li>
                        </ul>
                        <div class="cart_area">
                            <p>当前购物车总额：<?php echo $_SESSION['total_price']?></p>
                            <a class="btn btn-default" href="cart.php">去购物车结算</a>
                        </div>
                    </div>
                    <div class="col-xs-10">
                        <h3>唱片列表</h3>
                        <table class="table cd_table" id="cd_table">
                            <tbody>
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation" id="page_nav">
                            <ul class="pagination pagination-lg">
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="/static/js/jquery-3.1.1.min.js"></script>
    <script src="/static/js/bootstrap.min.js"></script>
    <script src="/static/js/my_slide.js"></script>
    <script>
        $(".my_slide").mySlide({speed:500});
        
        var page_index = 0;
        var page_size = 100;
        var page_num = 0;
        var option = '';

        function get_cd_table()
        {
            $.ajax({
                url:'get_sorted_list.php',
                type:'post',
                data:{'option':option,'page_index':page_index,'page_size':page_size},
                dataType:'json',
                success:function(data)
                {
                    var content = '<tr>';
                    $.each(data,function(i,obj){
                        if(i % 4 == 0 && i != 0)
                            content += "</tr><tr>";
                        content += "<td><a href='cd_detail.php?id=" + obj.id + "'><img src='/static/img/cover/" + obj.id + ".jpg' width='200px' height='200px'></a><p>" + obj.name + "</p><p>" + obj.artist + "</p></td>";
                    });
                    content += "</tr>";
                    $("#cd_table > tbody").html(content);
                },
                error:function(){
                    alert('网络异常，请稍后再试');
                }
            });
        }
        //分页就暂时先搁置着
        // function set_page_nav()
        // {

        //     var content = '';
        //     var max_nav_num = 0;

        //     //这段代码想要实现的是让分页导航条最多只显示5个，当剩下的页面不足5个是如实显示
        //     if(page_num > (parseInt(page_index) + 5))
        //         max_nav_num = (parseInt(page_index) + 5);
        //     else max_nav_num = page_num;

        //     if(page_index == 0)

        //         content += "<li class='disabled'><span aria-hidden='true'>&laquo;</span></li>";
        //     else content += "<li><span aria-hidden='true'>&laquo;</span></li>";

        //     for(var i = page_index;i < max_nav_num;i++)
        //         if(i == page_index)
        //             content += "<li class='active'><span>" + (parseInt(i)+1) + "</span></li>";
        //         else content += "<li><span>" + (parseInt(i)+1) + "</span></li>";

        //     if(page_num == page_index)
        //         content += "<li class='disabled'><span aria-hidden='true'>&laquo;</span></li>";
        //     else content += "<li><span aria-hidden='true'>&raquo;</span></li>";  

        //     $("#page_nav > ul").html(content);

        //     $("#page_nav > ul > li:not(:first,:last)").click(function(){
        //         page_index = parseInt($(this).text()) - 1;
        //         get_cd_table();
        //     });
        // }

        $(".order_controll > li").click(function(){
            option = $(this).attr('id').substring(8)
            get_cd_table();
        })

        $(function(){
            get_cd_table();
        })
    </script>
</body>
</html>