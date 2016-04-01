<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
$session=yii::$app->session;
$session->open();
?>
<link href="css/UserCSS.css" rel="stylesheet" type="text/css" />
<script src="js/ops.js" type="text/javascript"></script>
<script src="js/UserJS.js" type="text/javascript"></script>
<body>
<?php
require('./file/left.php');
?>
<link type="text/css" rel="stylesheet" href="css/tgv3_index.css">
<div class="u-main">
    <div class="ucenter">
        <div class="ucenter-info mt10">
            <div class="ucenter-tab-box">
                <ul>
                    <li><font>我的推荐</font></li>
                </ul>
            </div>
            <div id="tab_box">
                <style>
                    .list {width:200px;height:20px}
                </style>
                <div class="u-form-wrap">
                    <?php
                        if(empty($models)){
                            echo "<div style='width:400px;height:400px'><center><img src='images/wu.jpg'><br><span>您暂时无收藏</span></center></div>";
                        }else {
                            ?>
                            <table>
                                <?php
                                foreach ($models as $k => $v) {
                                    ?>
                                    <tr>
                                        <td class="list"><img src="<?php echo img_path;?><?= $v['t_p_img'] . " "; ?>" height="100px" width="50px" onerror="javascript:this.src='images/errors.jpg'"></td>
                                        <td class="list">
                                            <h4><?= $v['t_name'] ?></h4><?= mb_substr($v['t_content'], 0, 30, 'utf-8') . "..."; ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                            <?php
                            echo LinkPager::widget([
                                'pagination' => $pages,
                            ]);
                        }
                    ?>

                    </div>

        </div>
    </div>
    </div>
</div>
