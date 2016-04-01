<?php
/*
 *后台管理员、轮播图、酒店管理
 *作者：张俊虎、张晨阳、王鹏杰
 */

namespace backend\controllers;
use Yii;
use app\models\Admin;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use app\models\FirmAdminuser;
use app\models\Gropshop;
use app\models\GropType;
use app\models\Imgs;
use app\models\UploadForm;
use yii\web\UploadedFile;

class AdminController extends Controller
{
	public $enableCsrfValidation = false;

	/*
	 *后台登陆
	 *wpj
	 */
	
	public function actionLogin()
	{

		$model = new Admin;
    	if ($_POST) {
    		$user = $_POST['users'];
    		$verify = $model->verify();
    		if ($verify) {
    			$this->layout='header';
    			$session = Yii::$app->session;
    			if(!$session->isActive)
                {
                    $session->open();
                }
                $session->set('user',$user);
                $arr = $model->find()->where("a_name='$user'")->asArray()->all();
			foreach ($arr as $key => $value) {
				$id = $value['a_id'];
			}
			$select = $model->sele($id);
    		return $this->render('index',['select'=>$select]); 					
    		}else{
    			echo "<script>alert('用户名或密码错误');location.href='index.php?r=admin/login';</script>";
    		}
    	}else{
			$this->layout=false;
	    	return $this->render('sign-in');  					
    	}

	}

	/*
	 *后台退出
	 *wpj
	 */
	
	public function actionRemove()
	{

		$session = Yii::$app->session;
		$name = $session->remove("user");

	}

	/*
	 *首页显示
	 *wpj
	 */
	public function actionIndex()
	{

		$this->layout="header";
		$model = new Admin;;
		$session = Yii::$app->session;
		$name = $session->get("user");
		if ($name) {
			$arr = $model->find()->where("a_name='$name'")->asArray()->all();
			foreach ($arr as $key => $value) {
				$id = $value['a_id'];
			}
			$select = $model->sele($id);
    		return $this->render('index',['select'=>$select]);  			
		}else{
			echo "<script>alert('请登录');location.href='index.php?r=admin/login';</script>";
		}

	}

	/*
	 *admin列表显示
	 *wpj
	 */
	
	public function actionAdmins()
	{

		$this->layout="header";
		$model = new Admin;

		 if (empty($_GET['page'])) {
           $page = 1;
        }else{
            $page = $_GET['page'];
        }
		$pagesize = 3;
        $postCount = $model->find()->where('a_del=1')->count();
        $countpage = ceil($postCount/$pagesize);
        $limit2 = ($page-1)*$pagesize;
        $del = 1;
        $select = $model->selects($del,$limit2,$pagesize);
  		return $this->render('admins',['select'=>$select,'page'=>$page,'countpage'=>$countpage]); 

	}

	/*
	 *admin删除
	 *wpj
	 */
	
	public function actionA_del()
	{

		$this->layout="header";
		$model = new Admin;
		$session = Yii::$app->session;
		$name = $session->get("user");
		if ($name=="admin") {
		$id = $_GET["id"];
		$type = $_GET['type'];
		$del = $model->del($id,$type);
		if ($del) {
			echo "<script>location.href='index.php?r=admin/admins';</script>";
		}else{
			echo "<script>alert('失败');location.href='index.php?r=admin/admins';</script>";
		}
		}else{
		echo "<script>alert('不好意思，权限不够');location.href='index.php?r=admin/admins';</script>";
		}

	}

	/*
	 *admin密码修改
	 *wpj
	 */
	
	public function actionMima_upda()
	{

		$this->layout = "header";
		$model = new Admin;
		$session = Yii::$app->session;
		$name = $session->get("user");
		if ($name=="admin") {
		if ($_POST) {
			$id = $_POST['id'];
			$upda_mima = $model->upda_mima($id);
			// print_r($upda_mima);die;
			if ($upda_mima==1) {
			echo "<script>alert('成功');location.href='index.php?r=admin/admins';</script>";
		}else{
			echo "<script>alert('失败');location.href='index.php?r=admin/mima_upda&id='+$id;</script>";
		}

		}else{
			$id = $_GET["id"];
			$select = $model->sele($id);
			return $this->render("admins_mima",['select'=>$select]);
		}

	}

}

	/*
	 *admin信息修改
	 *wpj
	 */

	public function actionA_upda()
	{

		$this->layout = "header";
		$model = new Admin;
		$session = Yii::$app->session;
		$name = $session->get("user");
		if ($name=="admin") {
		if ($_POST) {
			$updates = $model->updates();
			if ($updates) {
			echo "<script>alert('成功');location.href='index.php?r=admin/admins';</script>";
		}else{
			echo "<script>alert('失败');location.href='index.php?r=admin/a_upda&id='+$id';</script>";
		}
		}else{
			$id = $_GET["id"];
			$select = $model->sele($id);
			return $this->render("admins_upda",['select'=>$select]);
		}
		}else{
		echo "<script>alert('不好意思，权限不够');location.href='index.php?r=admin/admins';</script>";
		}

	}

	/*
	 *admin添加
	 *wpj
	 */
	
	public function actionA_add()
	{

		$this->layout="header";
		$model = new Admin;
		if ($_POST) {
			$add = $model->adds();
			// print_r($add);die;
			if ($add) {
				echo "<script>alert('成功');location.href='index.php?r=admin/admins';</script>";
			}else{
				echo "<script>alert('失败');location.href='index.php?r=admin/a_add';</script>";
			}
		}else{
			return $this->render('admins_add');
		}

	}

	/*
	 *admin离职页显示
	 *wpj
	 */
	
	public function actionA_hui()
	{

		$this->layout="header";
		$model = new Admin;
				 if (empty($_GET['page'])) {
           $page = 1;
        }else{
            $page = $_GET['page'];
        }
        $connection = Yii::$app->db;
		$pagesize = 3;
        $postCount = $model->find()->where('a_del=0')->count();
        $countpage = ceil($postCount/$pagesize);
        $limit2 = ($page-1)*$pagesize;
        $del = 0;
        $select = $model->selects($del,$limit2,$pagesize);
		return $this->render('admins',['select'=>$select,'page'=>$page,'countpage'=>$countpage]);    

	}





	/*
	 *后台酒店页面
	 *wpj
	 */
		public function actionJiudian(){

		$this->layout="header";
		$connection = Yii::$app->db;
         if (empty($_GET['page'])) {
           $page = 1;
        }else{
            $page = $_GET['page'];
        }
        $pagesize = 2;
        $command = $connection->createCommand('SELECT COUNT(*) FROM gropshop');   
        $postCount = $command->queryScalar();
        $countpage = ceil($postCount/$pagesize);
        $limit2 = ($page-1)*$pagesize;
        $command = $connection->createCommand("SELECT * FROM gropshop limit $limit2,$pagesize");
        $arr = $command->queryAll();
        return $this->render('jiudian',['arr'=>$arr,'page'=>$page,'countpage'=>$countpage]);
	}
	/*
	 *酒店删除
	 *wpj
	 */
	public function actionJiudiandel(){

		$this->layout="header";
		  $model = NEW Gropshop;
		  $id = $_GET['id'];
		  $gropshopupdt1 = $model->gropshopupdt($id);
		if($gropshopupdt1){
				echo "<script> alert('删除成功');location.href='index.php?r=admin/jiudian' </script>";
            	//return $this->render('youqing');
		}else{
				echo "<script> alert('删除失败');location.href='index.php?r=admin/jiudian' </script>";
            	//return $this->render('youqing');
		}
	}
	/*
	 *酒店详细图片
	 *wpj
	 */
	public function actionJiudianimg(){

		$this->layout="header";
		$id =$_GET['id'];
		$model = new Gropshop;
		$jiudianimg = $model->jiudianimg($id);
		return $this->render('jiudianimg',['arr'=>$jiudianimg]);
	}
	/*
	 *酒店添加
	 *wpj
	 */
	public function actionJiudianadd(){

		$this->layout="header";
		 $connection = Yii::$app->db;
		 $command = $connection->createCommand("SELECT * FROM grop_type ");
		 $posts = $command->queryAll();
		 $model = new gropshop();
		return $this->render('jiudianadd',['arr'=>$posts,'model'=>$model]);
	}
	/*
	 *酒店添加完成
	 *wpj
	 */
	public function actionJiudianadd1(){

		$this->layout="header";
		$model = new gropshop();
        $b = $model->g_p_img = UploadedFile::getInstance($model, 'g_p_img');
            $arr=$model->g_p_img->saveAs('images/'.$model->g_p_img->baseName . '.' . $model->g_p_img->extension);
            $g_p_img = 'images/'.$model->g_p_img->name;
            $update = $model->doadd($g_p_img);
        if ($update) {
                echo "<script>alert('成功');location.href='index.php?r=admin/jiudian';</script>";
            }else{
                echo "<script>alert('错误');location.href='index.php?r=admin/jiudianadd';</script>";
            }
	
	}
	/*
	 *酒店修改
	 *wpj
	 */
	public function actionJiudianupdt(){

		$this->layout="header";
		$connection = Yii::$app->db;
        $id = $_GET['id'];
        $select = $connection->createcommand("SELECT * FROM gropshop WHERE g_id='$id'");
        $post1 = $select->queryOne();
        return $this->render('jiudianupdt',['post1'=>$post1]);
	}
	/*
	 *酒店修改完成
	 *wpj
	 */
	public function actionJiudianupdt2(){

		$this->layout="header";
		$connection = Yii::$app->db;
        @$g_name= $_POST['g_name'];
        @$g_money= $_POST['g_money'];
        @$g_content= $_POST['g_content'];
        @$g_place= $_POST['g_place'];
        @$g_coordinate= $_POST['g_coordinate'];
        @$id = $_POST['id'];
        $connection->createCommand("update gropshop set g_name='$g_name',g_money='$g_money',g_content='$g_content',g_place='$g_place',g_coordinate='$g_coordinate' where g_id='$id'")->execute();
        echo "<script> alert('修改成功');location.href='index.php?r=admin/jiudian'; </script>";
	}






	/*
	 *轮播图管理显示列表
	  作者：张晨阳
	 */
	public function actionLunbo()
	{
		
		$this->layout="header";
        $model = new Imgs();
        $info = $model->sel();
		$connection = Yii::$app->db;
         if (empty($_GET['page'])) {
           $page = 1;
        }else{
            $page = $_GET['page'];
        }
        $pagesize = 2;
        $command = $connection->createCommand('SELECT COUNT(*) FROM imgs');   
        $postCount = $command->queryScalar();
        $countpage = ceil($postCount/$pagesize);
        $limit2 = ($page-1)*$pagesize;
        $command = $connection->createCommand("select * from imgs where i_del=1 order by i_id desc limit $limit2,$pagesize");
        $arr = $command->queryAll();
        return $this->render('lunbo',['arr'=>$arr,'page'=>$page,'countpage'=>$countpage]);
	}

	/*
	  景点管理显示列表
	  作者：张晨阳
	 */
	public function actionZuire()
	{
		
		$this->layout="header";
		return $this->render('zuire');
	}

	/*
	 *轮播图管理移除调用页面
	  作者：张晨阳
	 */
	public function actionDel()
	{
		
		$id = $_GET['id'];
        $model = new Imgs();
        $info = $model->del();
	}

	/*
	 *轮播图管理执行修改
	  作者：张晨阳
	 */
	public function actionSave()
	{
		
		$this->layout="header";
		$model = new Imgs();
		$id = $_GET['id'];
		$info = $model->sel2($id);
		return $this->render('xiu',['model'=>$model,'id'=>$id,'info'=>$info]);
	}

	/*
	 *轮播图管理执行修改方法
	  作者：张晨阳
	 */
	public function actionUpload()
	{
		
		$this->layout="header";
		$model = new Imgs();
		$id = $_POST['id'];
        $b = $model->i_img = UploadedFile::getInstance($model, 'i_img');
        if($b){
            $arr=$model->i_img->saveAs('images/'.$model->i_img->baseName . '.' . $model->i_img->extension);
            $i_img = 'images/'.$model->i_img->name;
            $update = $model->upda($i_img);
        }else{
                $i_img = "";
                $update = $model->upda($i_img);
        }
        if ($update) {
                echo "<script>alert('成功');location.href='index.php?r=admin/lunbo';</script>";
            }else{
                echo "<script>alert('错误');location.href='index.php?r=admin/save';</script>";
            }

	}

	/*
	 *轮播图管理执行添加调用页面
	  作者：张晨阳
	 */
	public function actionAdd()
	{
		
		$this->layout="header";	
		$model = new Imgs();	
		return $this->render('add',['model'=>$model]);
	}

	/*
	 *轮播图管理执行添加方法
	  作者：张晨阳
	 */
	public function actionDoadd()
	{
		
		$this->layout="header";
		$model = new Imgs();
        $b = $model->i_img = UploadedFile::getInstance($model, 'i_img');
            $arr=$model->i_img->saveAs('images/'.$model->i_img->baseName . '.' . $model->i_img->extension);
            $i_img = 'images/'.$model->i_img->name;
            $update = $model->doadd($i_img);
        if ($update) {
                echo "<script>alert('成功');location.href='index.php?r=admin/lunbo';</script>";
            }else{
                echo "<script>alert('错误');location.href='index.php?r=admin/add';</script>";
            }
	}




}