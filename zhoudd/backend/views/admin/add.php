<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Bootstrap Admin</title>
    <link type="text/css" href="css/jquery-ui-1.8.17.custom.css" rel="stylesheet" />
     <link type="text/css" href="css/jquery-ui-timepicker-addon.css" rel="stylesheet" />
    <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.8.17.custom.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
    <script type="text/javascript" src="js/jquery-ui-timepicker-zh-CN.js"></script>
    <script type="text/javascript" charset="utf-8" src="ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="zh-cn.js"></script>
        <script type="text/javascript">
    $(function () {
        

        $(".ui_timepicker").datetimepicker({
            //showOn: "button",
            //buttonImage: "./css/images/icon_calendar.gif",
            //buttonImageOnly: true,
            showSecond: true,
            timeFormat: 'hh:mm:ss',
            stepHour: 1,
            stepMinute: 1,
            stepSecond: 1
        })
    })
    </script>
  </head>
  <body class=""> 
  <!--<![endif]-->
    <div class="content">
        
        <div class="header">
            <div class="stats">
    <p class="stat"><span class="number">53</span>tickets</p>
    <p class="stat"><span class="number">27</span>tasks</p>
    <p class="stat"><span class="number">15</span>waiting</p>
</div>

            <h1 class="page-title">Dashboard</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="index.html">Home</a> <span class="divider">/</span></li>
            <li class="active">Dashboard</li>
        </ul>

        <div class="container-fluid">


<?=Html::beginForm('index.php?r=admin/doadd' , 'post' , ['enctype' => 'multipart/form-data'])?>   <table>
    <tr>
        <td>图片</td>
        <td><?=Html::activeFileInput($model , 'i_img')?>
        </td>
    </tr>
    <tr>
        <td>开始时间</td>
        <td><!-- <input type="text" name="i_b_times"> --><input type="text" name="i_b_times" class="ui_timepicker" value=""></td>
    </tr>
    <tr>
        <td>结束时间</td>
        <td><input type="text" name="i_e_times" class="ui_timepicker" value=""></td>
    </tr>
    <tr>
        <td>景点名称</td>
        <td><input type="text" name="i_content"></td>
    </tr>
    <tr>
        <td>介绍</td>
        <td>
            <input type="text" id='js'>
            <script id="editor" type="text/plain" style="width:1024px;height:500px;" name='i_desc'></script>
        </td>
    </tr>
    <tr>
        <td colspan="2"><input type="submit" value="添加"><input type="reset" value="重置"></td>
        <td></td>
    </tr>
    </table>

        <?=Html::endForm();?>
        </div>
    </div>
    


    <script src="lib/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript">
        $('#js').focus(function(){
            var obj = $(this)
            // obj.val()
            var ue = UE.getEditor('editor');
            obj.remove();
        })
        

        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>
    
  </body>
</html>


