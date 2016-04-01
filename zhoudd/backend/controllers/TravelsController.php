<?php
	/*
	 *游记控制器
	 *wpj
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

class TravelsController extends Controller
{
	public $enableCsrfValidation = false;
	/*
	 *游记页面
	 *wpj
	 */
	public function actionYouji(){
			
		$this->layout="header";
		$connection = Yii::$app->db;
         if (empty($_GET['page'])) {
           $page = 1;
        }else{
            $page = $_GET['page'];
        }
        $pagesize = 3;
        $command = $connection->createCommand('SELECT COUNT(*) FROM travels');   
        $postCount = $command->queryScalar();/
        $countpage = ceil($postCount/$pagesize);
        $limit2 = ($page-1)*$pagesize;
        $command = $connection->createCommand("SELECT * FROM travels limit $limit2,$pagesize");
        $arr = $command->queryAll();
        return $this->render('travels',['arr'=>$arr,'page'=>$page,'countpage'=>$countpage]);
	}
	/*
	 *游记删除
	 *wpj
	 */
	public function actionTravelsdel(){
		
		$id = $_GET['id'];
		$model = NEW Travels;
		$del = $model->del($id);
		echo "<script> alert('删除成功');location.href='index.php?r=travels/youji' </script>";
	}
	/*
	 *游记恢复管理
	 *wpj
	 */
	public function actionYoujihuifu(){

		$this->layout="header";
		$connection = Yii::$app->db;
         if (empty($_GET['page'])) {
           $page = 1;
        }else{
            $page = $_GET['page'];
        }
        $pagesize = 3;
        $command = $connection->createCommand('SELECT COUNT(*) FROM travels');   
        $postCount = $command->queryScalar();
        $countpage = ceil($postCount/$pagesize);
        $limit2 = ($page-1)*$pagesize;
        $command = $connection->createCommand("SELECT * FROM travels inner join reply on travels.t_id=reply.t_id limit $limit2,$pagesize");
        $arr = $command->queryAll();
        return $this->render('reply',['arr'=>$arr,'page'=>$page,'countpage'=>$countpage]);
	}
}