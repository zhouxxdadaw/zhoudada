<?php

	/*
	 *前天用户管理
	 *张俊虎
	 */

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\message;

/**
 * Site controller
 */
class UserController extends Controller
{
	/*
	 *前天用户管理列表
	 *张俊虎
	 */
	
    public function actionIndex()
    {

    	$this->layout='header';
    	$model = new User;
    	$select = $model->selects();
    	return $this->render('user',['select'=>$select]);

    }

    /*
	 *前天用户管理删除
	 *张俊虎
	 */
    
    public function actionUser_del()
    {

    		$model = new User;
    	    $models = new message;
    		$id = $_GET['id'];
    		// print_r($id);die;
    		$del = $model->deleteAll("u_id = '$id'");
    		$dels = $models->deleteAll("u_id = '$id'");
    		if ($del and $dels) {
    			echo "<script>location.href='index.php?r=user/index'</script>";
    		}else{
    			echo "<script>alert('失败');location.href='index.php?r=user/index'</script>";
    		}
    }

}