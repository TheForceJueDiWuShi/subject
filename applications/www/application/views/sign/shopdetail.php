<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>
    <title>商品详情</title>
    <script src="<?php echo get_css_js_url('jquery-1.9.1.js', 'www')?>"></script>
    <script type="text/javascript" src="/WeixinPublic/plugins/layui/layui.js"></script>
    <link rel="stylesheet" href="<?php echo get_css_js_url('shopdetail.css', 'www')?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_css_js_url('gold/dialog.css', 'www')?>" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_css_js_url('ui-dialog.css', 'common')?>" media="all" />
    <script type="text/javascript" src="<?php echo get_css_js_url('gold/dialog_min.js', 'www')?>"></script>
    <script type="text/javascript" src="<?php echo get_css_js_url('dialog.js', 'common')?>"></script>
       
    <script type="text/javascript">
        var layer = '';
        layui.use(['layer'], function(){
            layer = layui.layer;
        });
    </script>
</head>
<body>

<!--div background-->
<div id="background">
   
    <div class="my_score">我的积分:
        <p id="score_p"><?php echo $userscore['score'] ?></p>
    </div>
   
    <!--div image-->
    <div class="detail_image">
        <img alt="" src="/WeixinPublic/images/caideng.jpg"> 
    </div> 
   
    <!--商品名-->
    <p class="title">商品名:&nbsp;<?php echo $info['title'] ?></p>
    
    <!--商品积分-->
    <p class="score">商品积分:&nbsp;<?php echo $info['score'] ?></p>
   
    <!--描述-->
    <div class="desc">
        <p>商品介绍:&nbsp;<?php echo $info['desc'] ?></p>
    </div>

    <!-- 兑换 -->
    <input id="Receive" value='兑换' type="button">
    
</div>

<script type="text/javascript">
    $('#Receive').click(function(){
    	var d = dialog({
    		content: '确定要兑换吗?',
    		okValue: '确定',
    		ok: function () {
    			d.close().remove();
    			$.ajax({
   	             type:"post",
   	             url:"/sign/exchange",
   	             dataType:'json',
   	             data:{id:<?php echo $info['id'] ?>},
   	             success:function (data) {
   	                 if(data.code == 1){
   	                 	layer.msg(data.msg);
   	                 }else{
   	                 	layer.msg(data.msg);
   	                 }

   	                 $("#score_p").text(data.score.score);
   	                 
   	             },
   	             error:function(){
   	             	layer.msg('未知错误！');
   	             }
   	         })
    		},
    		cancelValue: '取消',
    		cancel: function () {}
    	});
    	d.showModal();
     })
    
</script>

</body>
</html>


