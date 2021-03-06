<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <title>我来点评</title>
    <script type="text/javascript" src="/comment/pingfen/demo/js/jquery.min.js"></script>
    <script type="text/javascript" src="/comment/pingfen/lib/jquery.raty.min.js"></script>
    <script type="text/javascript" src="/comment/js/score.js"></script>
    <link rel="stylesheet" href="/comment/pingfen/demo/css/common.css">
    <link rel="stylesheet" href="/comment/css/commit.css">
    <script type="text/javascript" src="/WeixinPublic/plugins/layui/layui.js"></script>
    </head>
    <script type="text/javascript">
        var layer = '';
        layui.use(['layer'], function(){
            layer = layui.layer;

        });
    </script>

</head>
<body>

<!--最外层 背景框-->
<div class="flex-container">
    <!--总分层-->
    <div id="score_all" class="siicsc">
        <div id="score_all_text" class="score_text">总分:</div>
        <div id="rank_background" class="demo">
            <div id="function-demo_all" class="target-demo"></div>
            <div id="function-hint_all" class="hint"></div>
        </div>
    </div>
    <input type="hidden" id="company_id" value="<?php if(isset($id)){echo $id;}else{echo 0;}?>"/>
    <!--input 1 层-->
    <div id="input_1" class="siicsc">
        <textarea class="ipt_1" placeholder="菜品如何，服务周到吗，环境怎么样，（写够15个字才是好同志哦~）"></textarea>
    </div>

    <!--input 2 层-->
    <div id="input_2" class="siicsc">
        <div id="xiaofei"></div>
        <input type="number" class="ipt_2" placeholder="人均消费价格" />
    </div>

    <!--相机层-->
    <div id="camara_all" class="siicsc">
        <input id="upload" data="0" type="button" >
    </div>
   <!-- <button id="upload" data="0">拍照（点击一次上传一张）</button>-->
  
    <!--评分层-->
    <div id="score_single" class="siicsc">

        <div class="score_s">
            <div id="score_h_text" class="score_text">环境:</div>
            <div class="demo">
                <div id="function-demo_h" class="target-demo" style"width:140px"></div>
                <div id="function-hint_h" class="hint"></div>
            </div>

        </div>


        <div class="score_s">
            <div id="score_f_text" class="score_text">服务:</div>
            <div class="demo">
                <div id="function-demo_f" class="target-demo"></div>
                <div id="function-hint_f" class="hint"></div>
            </div>

        </div>


        <div class="score_s">
            <div id="score_k_text" class="score_text">口味:</div>
            <div class="demo">
                <div id="function-demo_k" class="target-demo"></div>
                <div id="function-hint_k" class="hint"></div>
            </div>

        </div>

    </div>

    <!--提交层-->
    <div id="cmit">
        <input style="width: 9rem;height: 2rem;font-size: 1.25rem;" type="button"  id="btn" value="提交" >
    </div>
    
<?php $this->load->view('common/camera_album');?>  
</div>
</body>
</html>
