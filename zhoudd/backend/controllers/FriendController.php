<?php
	/*
	 *友情链接
	 *张俊虎
	 */

namespace backend\controllers;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use app\models\Friendlist;
use app\models\kefu;

class FriendController extends Controller
{
	public $enableCsrfValidation = false;
	/*
	 *友情链接显示
	 *张俊虎
	 */
	public function actionIndex()
	{

		$this->layout='header';
		$model = new Friendlist;
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
	 *友情链接添加
	 *张俊虎
	 */
	
	public function actionAdd()
	{

		$this->layout='header';
		$model = new Friendlist;
		if ($_POST) {
			$insert = $model->inserts();
			if ($insert) {
				echo "<script>alert('成功');location.href='index.php?r=friend/index'</script>";
			}else{
				echo "<script>alert('失败');location.href='index.php?r=friend/add'</script>";
			}
		}else{
			return $this->render('add');
		}

	}

	/*
	 *友情链接删除
	 *张俊虎
	 */

	public function actionDel()
	{

		$id = $_GET['id'];
		$model = new Friendlist;
		$del = $model->deleteAll("f_id='$id'");
		if ($del) {
			echo "<script>alert('成功');location.href='index.php?r=friend/index'</script>";
		}else{
			echo "<script>alert('失败');location.href='index.php?r=friend/index'</script>";
		}

	}

	/*
	 *友情链接修改
	 *张俊虎
	 */
	
	public function actionUpda()
	{

		$this->layout='header';
		$model = new Friendlist;
		if ($_POST) {
			$upda = $model->upda();
			if ($upda) {
				echo "<script>alert('成功');location.href='index.php?r=friend/index'</script>";
			}else{
				$id = $_POST['f_id'];
				echo "<script>alert('失败');location.href='index.php?r=friend/upda&id='+'$id'</script>";
			}
		}else{
			$id = $_GET['id'];
			$select = $model->find()->where("f_id='$id'")->asArray()->all();
			return $this->render('upda',['select'=>$select]);
		}

	}

	/*
	 *客服管理列表
	 *张俊虎
	 */
	
	public function actionQq()
	{

		$this->layout='header';
		$model = new kefu;
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
  		return $this->render('qqlist',['select'=>$select,'page'=>$page,'countpage'=>$countpage]); 

	}

	/*
	 *客服管理删除
	 *张俊虎
	 */

	public function actionQq_del()
	{

		$id = $_GET['id'];
		$model = new kefu;
		$del = $model->deleteAll("q_id='$id'");
		if ($del) {
			echo "<script>alert('成功');location.href='index.php?r=friend/qq'</script>";
		}else{
			echo "<script>alert('失败');location.href='index.php?r=friend/qq'</script>";
		}

	}

	/*
	 *客服管理修改
	 *张俊虎
	 */
	
		public function actionQq_upda()
	{

		$this->layout='header';
		$model = new kefu;
		if ($_POST) {
			$upda = $model->upda();
			if ($upda) {
				echo "<script>alert('成功');location.href='index.php?r=friend/qq'</script>";
			}else{
				$id = $_POST['f_id'];
				echo "<script>alert('失败');location.href='index.php?r=friend/qq_upda&id='+'$id'</script>";
			}
		}else{
			$id = $_GET['id'];
			$select = $model->find()->where("q_id='$id'")->asArray()->all();
			return $this->render('qq_upda',['select'=>$select]);
		}

	}

	/*
	 *客服管理添加
	 *张俊虎
	 */
	
	public function actionQq_add()
	{

		$this->layout='header';
		$model = new kefu;
		if ($_POST) {
			$insert = $model->inserts();
			if ($insert) {
				echo "<script>alert('成功');location.href='index.php?r=friend/qq'</script>";
			}else{
				echo "<script>alert('失败');location.href='index.php?r=friend/qq_add'</script>";
			}
		}else{
			return $this->render('qq_add');
		}
	}
	
}