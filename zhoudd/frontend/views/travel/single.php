<script type="text/javascript" charset="utf-8" src="js/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="js/ueditor.all.min.js"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="js/lang/zh-cn/zh-cn.js"></script>
	<div class="blog">
		<div class="container">
			<div class="blog-top">
				<div class="col-md-9 blog-left">
					<div class="blog-main">
						<a class="bg"><?= $list_arr['t_title']?></a>
					</div>								
					<div class="blog-main-one">
						<div class="blog-one blog-sng">
							<img src="<?= $list_arr['t_img']?>" alt="" width="200" height="500" />
							<p class="sngl"><?= $list_arr['t_content']?></p>
						</div>	
						<div class="comments cmt">
								<ul>
									<li><span class="bookmark"> </span><a href="#">回复(10)</a></li>
									<li><span class="clndr"> </span><p title="品论时间"><?= $list_arr['t_times']?></p></li>
									<li><span class="cmnt"> </span><a href="index.php?r=data/user" title="最后回复人"><?= $list_arr['u_name']?></a></li>
								</ul>
						</div>	
					</div>	
					<div class="comment-list">
					
					<?php foreach($reply_arr as $key=>$val){ ?>
					<div class="comments cmt">
					<table>
					<tr>
						<font color="red">用户头像</font><td><img src="<?= $val['m_img']?>" alt="用户头像" width="200" height="200" onerror="this.src='images/025632646.jpg'" /></td>
						<td>
							<tr>
								<td>评论内容 </td><td title="评论内容："><?= $val['re_content']?></td><br />
							</tr>
							<tr>
								<td>评论人：</td><td><?= $val['m_name']?></td>
							</tr>
						</td>
					</tr>
					</table>
							<h5></h5></div>
							<?php } ?>
						</div>
						<div class="content">
					 		<h3>评论</h3>
					 		<div class="contact-form">
								<form method="post" action="index.php?r=travel/reply">
									<script id="editor" type="text/plain" style="width:830px;height:200px;" name="content"></script>
									<input type="hidden" value="<?= $list_arr['t_id']?>" name="t_id" />
									<input type="hidden" value="<?= $list_arr['u_id']?>" name="u_id" />
									<input type="submit" value="评论"/>
				   				</form>
				   			</div>	
						</div>
				</div>
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
		</div>
	</div>
	
	<script type="text/javascript">
		var ue = UE.getEditor('editor');
	</script>
	<!--blog-->
	<!--read-->
	@stop