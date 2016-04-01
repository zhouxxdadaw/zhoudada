<?php

/*
 *admins控制器主要是景点管理
  作者：张晨阳
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
use app\models\travel;
use app\models\city;
use app\models\season;

class AdminsController extends Controller
{

	/*
	*景点管理显示列表
	作者：张晨阳
	*/	
	public function actionTravel()
	{
		
		$this->layout="header";
		$model = new travel();
		$info = $model->sel();
		$connection = Yii::$app->db;
         if (empty($_GET['page'])) {
           $page = 1;
        }else{
            $page = $_GET['page'];
        }
        $pagesize = 3;
        $command = $connection->createCommand('SELECT COUNT(*) FROM travel');   
        $postCount = $command->queryScalar();
        $countpage = ceil($postCount/$pagesize);
        $limit2 = ($page-1)*$pagesize;
        $command = $connection->createCommand("select * from travel inner join city on travel.c_id=city.c_id inner join season on travel.s_id=season.s_id  where travel.t_del=1 order by t_id desc limit $limit2,$pagesize");
        $arr = $command->queryAll();
        return $this->render('travel',['arr'=>$arr,'page'=>$page,'countpage'=>$countpage]);
	}

	/*
	*景点管理移除方法调用页面
	作者：张晨阳
	*/	
	public function actionDel()
	{
		
		$model = new travel();
		$info = $model->del();
	}

	/*
	*景点管理添加跳转页面
	作者：张晨阳
	*/	
	public function actionAddtravel()
	{
		
		$this->layout="header";
		$model = new travel();
		$c = new city();
		$s = new season();
		$info = $c->sel();
		$arr = $s->sel();
        return $this->render('addtravel',['info'=>$info,'model'=>$model,'arr'=>$arr]);
	}

	/*
	*景点管理执行添加方法
	作者：张晨阳
	*/	
	public function actionDoaddtravel()
	{
		
		$this->layout="header";
		$model = new travel();
        $b = $model->t_p_img = UploadedFile::getInstance($model, 't_p_img');
            $arr=$model->t_p_img->saveAs('images/'.$model->t_p_img->baseName . '.' . $model->t_p_img->extension);
            $t_p_img = 'images/'.$model->t_p_img->name;
            $update = $model->doadd($t_p_img);
        if ($update) {
                echo "<script>alert('添加成功');location.href='index.php?r=admins/travel';</script>";
            }else{
                echo "<script>alert('添加错误');location.href='index.php?r=admins/addtravel';</script>";
            }
	}

	/*
	*景点管理执行修改方法调用页面
	作者：张晨阳
	*/	
	public function actionSave()
	{
		
		$this->layout="header";
		$id = $_GET['id'];
		$model = new travel();
		$c = new city();
		$s = new season();		
		$info = $c->sel();
		$arr = $s->sel();
		$infos = $model->sel2($id);
		return $this->render('xiu',['model'=>$model,'arr'=>$arr,'info'=>$info,'infos'=>$infos]);

	}

	/*
	*景点管理执行添加方法
	作者：张晨阳
	*/	
	public function actionDosave()
	{
		
		$this->layout="header";
		$model = new travel();
		$id = $_POST['id'];
        $b = $model->t_p_img = UploadedFile::getInstance($model, 't_p_img');
        if($b){
            $arr=$model->t_p_img->saveAs('images/'.$model->t_p_img->baseName . '.' . $model->t_p_img->extension);
            $t_p_img = 'images/'.$model->t_p_img->name;
            $update = $model->dosave($t_p_img);
        }else{
                $t_p_img = "";
                $update = $model->dosave($t_p_img);
        }
        if ($update) {
                echo "<script>alert('修改成功');location.href='index.php?r=admins/travel';</script>";
            }else{
                echo "<script>alert('修改错误');location.href='index.php?r=admins/save';</script>";
            }

	}

}