<?php
/*
*周边游
*Author：崔凯强
*/
namespace frontend\controllers;
use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Travelaround;


class TravelaroundController extends Controller
{
	/*
	*周边游首页（含城市定位及显示最新最热景点和酒店推荐）
	*/
	public function actionIndex()
	{

		$ad_api_url='http://api.k780.com:88/?app=ip.get&appkey=17358&sign=691de9160c83f75c9d397d26409cb714&format=json';
		@$info = file_get_contents($ad_api_url);
		@$infos = json_decode($info);
		@$area = $infos->result->att;
		@$citys = explode(',',$area);
		@$city = $citys['1'];
		@$_CFG['city'] = $city;
		$this->layout="header";
		$model=new Travelaround();
		$city=$model->select_city($city);
		$id=$city['c_id'];
		$arr=$model->select_all($id);
		$pages=$arr['pages'];
		$info=$arr['info'];
		$hotel=$model->select_hotel($id);
		$page=$hotel['pa'];
		$row=$hotel['info'];
		$else=$model->select_else();
		$p=$else['pages'];
		$e=$else['else'];
		$el=$model->sel_hotels();
		$pa=$el['pages'];
		$els=$el['info'];
    	return $this->render('index',['pages'=>$pages,'arr'=>$info,'city'=>$city,'hotel'=>$hotel,'page'=>$page,'row'=>$row,'p'=>$p,'e'=>$e,'pa'=>$pa,'els'=>$els]);
	}
	/*
	*根据用户搜索的城市搜索景点及酒店
	*/
	public function actionSearch(){

		$request = Yii::$app->request;
		$city=$request->get('city');
		$model=new Travelaround();
		$arr=$model->search($city);
		$page=$arr['pages'];
		$row=$arr['info'];
		$hotel=$model->sea_hotel($city);
		$pages=$hotel['pages'];
		$info=$hotel['info'];
		$else=$model->sea_scenery();
		$p=$else['p'];
		$sce=$else['info'];
		$el=$model->sea_ho();
		$pa=$el['p'];
		$hot=$el['info'];
		if (@$_GET['page']) {
			$this->layout='header';
		}else{
			$this->layout=false;
		}
		return $this->render('search',['arr'=>$arr,'hotel'=>$hotel,'pages'=>$page,'row'=>$row,'page'=>$pages,'info'=>$info,'citys'=>$city,'p'=>$p,'sce'=>$sce,'pa'=>$pa,'hot'=>$hot]);
	}
}