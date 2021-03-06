<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=no">
    <meta name="poweredby" content="gztwkj.cn" />
    <title><?php echo $info['id'];?>号选手 <?php echo $info['fullname'];?></title>
    <link rel="stylesheet" href="/WeixinPublic/css/style.css" />
    <script type="text/javascript" src="/WeixinPublic/js/jquery-1.9.1.js" ></script>

    <script>
        window.onload=function(){
            $(".load").hide();
        }
    </script>
    <style>
        .con{ width: 100%; display: none; background: #404a53;  z-index: 100; position: fixed !important; opacity: 0.3;}
        .tp{ background: #2CCB6F; color:#FFFFFF; text-align:center; margin-left:5%; margin-top:4px; margin-right:4px; width:40%; padding:6px 0px; border-radius:8px; -webkit-border-radius:8px; -moz-border-radius:8px; float:left; display:block;}
        .xyimg img{ width:100%; margin-bottom:5px;margin-top:5px;}
        #erpic img{ width:60%;}
        #erpic{ width:100%; text-align:center; background:#ededed; margin-top:5px; padding-top:8px; padding-bottom:8px;}
        .user_top{ position:relative;}
        .user_top a {
            display: block;
            border-radius: 6px;
            padding: 4px;
            color: #F9F9F9;
            width: 80px;
            text-align: center;
            position: absolute;
            left: -5px;
            top: -5px;
        }
   </style>

    <script>
        var vid="{$vid}";
        var token="{$token}";
    </script>
</head>
<body>
<div class="user_top">
    <a href="javascript:window.history.go(-1);" style="left: -20px">返回</a>
    <?php echo $info['id'] ?>号选手 <?php echo $info['fullname'] ?>
</div>

<div class="user_p">
    <ul>
        <li>
            <p><font color="#b52622"><?php echo $info['vote_num']  ?></font>票</p>
        </li>
        <li>
            <p>当前排名:<font color="#b52622"><?php echo $info['order']  ?></font></p>
        </li>
    </ul>
</div>
<div class="xuanyan">
    <p>演员简介：</p>
    <p style="text-align:left; border-bottom:1px solid pink; padding:5px 0px;"><?php echo $info['desc']  ?></p>
    <p class="xyimg">


        <img src=<?php echo "/uploads/images/".$info['cover_img']  ?>>




    </p>

</div>

<div class="user_p">
    <ul>
        <li>
            <p><font color="#b52622"><?php echo $info['vote_num']  ?></font></p>
            <p>投票次数</p>
        </li>
        <li>
            <p><font color="#b52622"><?php echo $info['visits']  ?></font></p>
            <p>围观人数</p>
        </li>
    </ul>
</div>

<div class="tou">
    <p id="tp">投票</p>
    <?php if($status):?>
    <p id="cj">抽奖</p>
    <?php endif;?>
</div>

<div id="guanzhu" style="text-align: center; display:none;">
    <img alt="官方微信公众号" width="60%;" src="/uploads/images/fangzhou/fangzhouQRcode.jpg"/>
    <h3>【请先关注微信公众号】</h3>
</div>


<div class="copy"><a href="#" style="color:#9c9c9c">****提供技术支持</a></div>

<script src="/WeixinPublic/plugins/layui/layui.js"></script>
<script type="text/javascript" >
    var layer = '';
    layui.use(['layer'], function(){
        layer = layui.layer
    });
    $(function(){
        $('#cj').on('click', function(){
        	window.location.href = "/lotterys";
        });
        $("#tp").click(function(){
            var item_id = $(this).attr("alt");
            $.ajax({
                type: "post",
                url : '/index.php/Weixin/vote_to_performer',
//                url:'http://test-www.test.com/index.php/Weixin/vote_to_performer',
                dataType:'json',
                data: {vid:vid,item_id:item_id,token:token,token_id:<?php echo $info['id'] ?>},
                success: function(data){
                    if(data.code == 1){
                        layer.msg(data.msg);
	                    if(data.status && data.status == 1){
	                        setInterval(function(){
	                            window.location.reload();
	                        }, 3000);
                        }
                    }else if(data.code == -1){
                    	layer.msg(data.msg);
                        //提醒关注微信关注号
                    	$('#guanzhu').show();
                    }else{
                        layer.msg(data.msg);
                    }

                }

            });
        })
    })

</script>



<div class="load">
    <p><img src="/WeixinPublic/images/loading.gif" /></p>
    <p id="txt">加载中....</p>
</div>

<?php $this->load->view('common/share_common.php')?>
</body>

</html>
