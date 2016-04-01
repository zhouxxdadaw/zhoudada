<?php

	/*
	 *导航栏管理
	 *张俊虎
	 */

namespace backend\controllers;
use Yii;
use app\models\Travels;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use app\models\FirmAdminuser;
use app\models\Gropshop;
use app\models\GropType;
use app\models\Imgs;
use app\models\UploadForm;
use app\models\Gps;

class GpsController extends Controller
{
	public $enableCsrfValidation = false;
	/*
	 *导航栏显示
	 *张俊虎
	 */
	
	public function actionIndex()
	{

		$this->layout='header';
		$model = new Gps;
		 if (empty($_GET['page'])) {
           $page = 1;
        }else{
            $page = $_GET['page'];
        }

		$pagesize = 3;
        $postCount = $model->find()->count();
        $countpage = ceil($postCount/$pagesize);
        $limit2 = ($page-1)*$pagesize;
        $select = $model->selects($limit2,$pagesize);
  		return $this->render('index',['select'=>$select,'page'=>$page,'countpage'=>$countpage]); 

	}

	/*
	 *客服管理添加
	 *张俊虎
	 */
	
	public function actionAdd()
	{

		$this->layout='header';
		$model = new Gps;
		if ($_POST) {
			$insert = $model->inserts();
			if ($insert) {
				echo "<script>alert('成功');location.href='index.php?r=gps/index'</script>";
			}else{
				echo "<script>alert('失败');location.href='index.php?r=gps/add'</script>";
			}
		}else{
			return $this->render('add');
		}

	}

	/*
	 *客服管理删除
	 *张俊虎
	 */

	public function actionDel()
	{
		$id = $_GET['id'];
		$model = new Gps;
		$del = $model->deleteAll("g_id='$id'");
		if ($del) {
			echo "<script>alert('成功');location.href='index.php?r=gps/index'</script>";
		}else{
			echo "<script>alert('失败');location.href='index.php?r=gps/index'</script>";
		}
	}

	/*
	 *客服管理修改
	 *张俊虎
	 */
	
	public function actionUpda()
	{
		$this->layout='header';
		$model = new Gps;
		if ($_POST) {
			$upda = $model->upda();
			// print_r($upda);die;
			if ($upda) {
				echo "<script>alert('成功');location.href='index.php?r=gps/index'</script>";
			}else{
				$id = $_POST['g_id'];
				echo "<script>alert('失败');location.href='index.php?r=gps/upda&id='+'$id'</script>";
			}
		}else{
			$id = $_GET['id'];
			$select = $model->find()->where("g_id='$id'")->asArray()->all();
			return $this->render('upda',['select'=>$select]);
		}
	}
	
}