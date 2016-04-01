<?php
/**
  *游记模块
  *金跃虎
  *
  */
namespace frontend\controllers;
use Yii;
use common\models\LoginForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\base\Model;
use app\models\Travels;
use yii\web\UploadedFile;
/**
  *发表帖子模块
  *金跃虎
  */
class TravelController extends Controller
{
	/**
	 *显示帖子页面
	 *
	 */
	public function actionTravel()
	{
		$this->layout="header";
		$model = new Travels;
		$connection = \Yii::$app->db;
		$command = $connection->createCommand('SELECT * FROM travels inner join user on travels.u_id = user.u_id order by t_id desc limit 7');
		$post_arr = $command->queryAll();
		return $this->render('blog',['post_arr'=>$post_arr,'model'=>$model]);
	}
	/**
	 *	上传景点帖子
	*/
    public function actionUpload()
    {	
		$session = Yii::$app->session;	
        $session->open();
		if(isset($_SESSION['u_id'])){
		$title = $_POST['title'];
		$content = $_POST['content'];
		$session = $_SESSION['u_id'];
		date_default_timezone_set('PRC');
		$date = date('Y-m-d h:m:s ',time());
        $model = new Travels();
		$model->t_img = UploadedFile::getInstance($model, 't_img');
		$arr=$model->t_img->saveAs('../../frontend/web/images/'.$model->t_img->baseName . '.' . $model->t_img->extension);
		$article = new \app\models\Travels();
        $article -> t_content =$content;
		$article -> t_title =$title;
		$article -> t_times =$date;
		$article -> u_id =$session;
        $article -> t_img ='images/'.$model->t_img->name;
        $re=$article -> save();
		if($re) {
			echo "<script>alert('发表成功');location.href='index.php?r=travel/travel'</script>";
		}
		} else {
			echo "<script>alert('请先登录');location.href='index.php?r=login/login'</script>";
		}
    }
	/** 
	 *帖子详情
	 */
	public function actionSingle()
	{
		$this->layout="header";
		$id = $_GET['id'];
		$connection = \Yii::$app->db;
		$command = $connection->createCommand("SELECT * FROM travels inner join user on travels.u_id = user.u_id where t_id = '$id'");
		$post_arr = $command->queryOne();
		$command = $connection->createCommand("SELECT * FROM reply inner join user on reply.u_id = user.u_id join message on message.u_id = user.u_id where t_id = '$id' order by date desc limit 5");
		$reply_arr = $command->queryAll();
		return $this->render('single.php',['list_arr'=>$post_arr,'reply_arr'=>$reply_arr]);

	}
	public $enableCsrfValidation = false;
	public function actionReply()
	{
		$this->layout="header";
		$session = Yii::$app->session;	
        $session->open();
		if(isset($_SESSION['u_id'])){
		$content = $_POST['content'];
		$t_id = $_POST['t_id'];
		$session = $_SESSION['u_id'];
		date_default_timezone_set('PRC');
		$date = date('Y-m-d h:m:s ',time());
		$u_id = $_POST['u_id'];
		$connection = \Yii::$app->db;
		$re = $connection->createCommand()->insert('reply', [
		're_content' => $content,
		't_id' => $t_id,
		'u_id' => $session,
		'date' => $date,
		'u_id' => $u_id,
		])->execute();
		$connection = \Yii::$app->db;
		$command = $connection->createCommand("SELECT * FROM travels inner join user on travels.u_id = user.u_id where t_id = '$t_id'");
		$post_arr = $command->queryOne();
		$command = $connection->createCommand("SELECT * FROM reply inner join user on reply.u_id = user.u_id join message on message.u_id = user.u_id where t_id = '$t_id' order by date desc limit 5");
		$reply_arr = $command->queryAll();
		return $this->render('reply.php',['list_arr'=>$post_arr,'reply_arr'=>$reply_arr]);
		} else {
			echo "<script>alert('请先登录');location.href='index.php?r=login/login'</script>";
		}
		
	}
}