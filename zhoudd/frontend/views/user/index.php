
<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
require('./file/left.php');
?>
<div class="u-main">
    <div class="ucenter">
        <div style="margin-left:60px">
        <?php $form = ActiveForm::begin([
            'action'=>Url::toRoute(['user/userinfo']),
            'method'=>'post',
        'options' => ['enctype' => 'multipart/form-data'],]) ?>
        <?= $form->field($model, 'm_name')->label('昵称：') ?>
            <?= Html::hiddenInput('u_id',$model->u_id) ?>
        性别：<?= Html::radioList('m_sex',$model->m_sex,['0'=>'男','1'=>'女','2'=>'保密']) ?>
            <?= $form->field($model, 'm_img')->fileInput()->label('头像:') ?>
            <?php
                if($model->m_img){
                    ?>
                    <img src="<?php echo img_path;?><?= $model->m_img?>" width="40px" height="40px" onerror="javascript:this.src='images/error.jpg'"/>
            <?php
                }
            ?>
            <?= $form->field($model, 'm_tel')->label('手机号：') ?>
        <div class="form-group">        <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('修改', ['class' => 'btn btn-primary']) ?>
            </div>    </div>
        <?php ActiveForm::end() ?>
            </div>
        <script type="text/javascript">

            var $div_li = $(".ucenter-tab-box ul li");

            $div_li.click(function () {

                $(this).addClass("current").siblings().removeClass("current");

                var div_index = $div_li.index(this);

                $("#tab_box>div").eq(div_index).show().siblings().hide();

            }).hover(function () {

                $(this).addClass("hover");

            }, function () {

                $(this).removeClass("hover");

            });

        </script>
    </div>
    <!-- /.u-main -->
</div>
