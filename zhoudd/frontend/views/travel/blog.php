<script type="text/javascript" charset="utf-8" src="js/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="js/ueditor.all.min.js"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="js/lang/zh-cn/zh-cn.js"></script>
	<div class="blog">
		<div class="container">
			<div class="blog-top">
			<?php foreach($post_arr as $key=>$val){ ?>
				<div class="col-md-9 blog-left">
					<div class="blog-main">
						<a href="single.html" class="bg" color="red"><?= $val['t_title']?></a>
					</div>
					
					<div class="blog-main-one">
						<div class="blog-one">
							<div class="col-md-5 blog-one-left">
								<a href="index.php?r=travel/single&id=<?= $val['t_id']?>"><img src="<?= $val['t_img']?>" alt="" width="70" height="270" /></a>
							</div>
							<div class="col-md-7 blog-one-left">
								<p>
								<?php echo mb_strlen($val['t_content'],'utf-8')>50?mb_substr($val['t_content'],0,50,'utf-8').'……':$val['t_content'];?>
								</p>
							</div>
							<div class="clearfix"></div>
						</div>	
						<div class="comments">
								<ul>
									<li><span class="bookmark"> </span><a href="index.php?r=data/user" title="作者"><?= $val['u_name'] ?></a></li>
									<li><span class="clndr"> </span><a href="#"  title="添加时间"><?= $val['t_times'] ?></a></li>
								</ul>
								<div class="b-btn">
									<a href="index.php?r=travel/single&id=<?= $val['t_id']?>" class="hvr-shutter-out-horizontal">查看详情</a>
								</div>
								<div class="clearfix"></div>
						</div>	
					</div>
					</div>
					<?php } ?>
			<div class="col-md-3 blog-right">
					<div class="categories">
						<h3>CATEGORIES</h3>
						<ul>
							<li><a href="#">Aenean tortor orci</a></li>
							<li><a href="#">Duis bibendum pellentesquev</a></li>
							<li><a href="#">Quisque pharetra semper</a></li>
							<li><a href="#">Cras condimentum risus</a></li>
							<li><a href="#"> Quisque id erat sapien</a></li>
						</ul>
					</div>
				</div>
				
				<div class="clearfix"></div>
			</div>
			<div class="pagination">
				<nav>
  					<ul class="pager">
    							<li><a href="#">Previous</a></li>
    							<li><a href="#">Next</a></li>
  					</ul>
				</nav>
			</div>
		</div>
		<div class="categories">
<center>
<h2><font color="red">发表新帖</font></h2><br />
<table width="50%">

	<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	?>

	<?= Html::beginForm('index.php?r=travel/upload' , 'post' , ['enctype' => 'multipart/form-data']) ?>
	<table>
	<tr>
		<td>帖子标题：</td>
		<td><input type="text" name='title' /></td>
	</tr>
	<tr>
		<td>景点展示：</td>
		<td><?= Html::activeFileInput($model, 't_img')?></td>
	</tr>
	<tr>
		<td>帖子内容：</td>
		<td><script id="editor" type="text/plain" style="width:500px;height:200px;" name="content"></script></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" value="发表帖子" /></td>
	</tr>
	</table>

	<?= Html::endForm(); ?>
</form>
</table>
</center>
	</div>
	</div>
	<script type="text/javascript">
		var ue = UE.getEditor('editor');
	</script>

	<!--blog-->
	<!--read-->
