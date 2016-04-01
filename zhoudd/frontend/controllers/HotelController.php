<?php

/**
 * 酒店模块
 * 作者 周祥祥
 */

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use app\models\Gropshop;
use app\models\City;
use yii\widgets\LinkPager;
use yii\data\Pagination;

/**
 * Hotel Controller
 */

class HotelController extends Controller
{


	/**
	 * 酒店
	 */
	public function actionHotel()
	{

		$this->layout="header";	
		$model = new Gropshop;
		$hotel = Yii::$app->db;

		$re = $model->hot_hotel_best();	
		$re['g_content'] = substr($re['g_content'], 0,530);

		$arr = $model->hot_city();
		$result = $model->hot_hotel();
		
		return $this->render('news',['re'=>$re,'arr'=>$arr,'result'=>$result]);		

	}



	/**
	 * 热门城市酒店详情
	 */
	public function actionHotel_about()
	{

		$this->layout = "header";
		$model = new Gropshop;
		$models = new City;
		$hotel = Yii::$app->db;
		$id = $_GET['id'];
		
		$re = $model->city_about($id);
		$arr = $model->city_place($id);
		$travel_result = $models->travel($id);

		$sql = "SELECT * FROM city INNER JOIN gropshop ON city.c_id = gropshop.c_id WHERE city.c_id = '$id' and gropshop.g_del = 1 ORDER BY gropshop.g_num DESC ";

		$q = Yii::$app->db->createCommand($sql)->queryAll();
		$pages = new Pagination([
		    'defaultPageSize' => 2,
		    'totalCount'=>count($q),
		]);
		$list = Yii::$app->db->createCommand($sql." limit ".$pages->limit." offset ".$pages->offset."")->queryAll();

		return $this->render('hotel_about',['re'=>$re,'arr'=>$arr,'c'=>$list,'travel_result'=>$travel_result,'pages'=>$pages]);

	}


	/**
	 * 酒店详情
	 */
	public function actionHot_about()
	{

		$this->layout = "header";
		$model = new Gropshop;
		$models = new City;
		$hotel = Yii::$app->db;
		$id = $_GET['id'];


		$re = $model->hotel_about($id);
	
		$coo = $hotel->createCommand("SELECT g_coordinate FROM gropshop WHERE g_id = '$id'");
		$c = $coo->queryOne();

		$arr2 = $models->city();

		return $this->render('hot_about',['re'=>$re,'arr2'=>$arr2,'c'=>$c]);

	}

	/**
	 * 城市酒店搜索
	 */
	public function actionSearch()
	{

		$hotel = $_GET['hot'];
		$model = new Gropshop;

		$re = $model->search($hotel);
		return $this->renderpartial('search',['c'=>$re]);

	}
}
