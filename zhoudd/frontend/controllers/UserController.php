<?php
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
use app\models\Message;
use yii\web\UploadedFile;
use yii\data\Pagination;
use app\models\Extension;
use app\models\GoodsLog;
class UserController extends Controller
{
    public $layout='header';
    //显示修改页面
	public function actionIndex()
	{
        $request=Yii::$app->request;
        //接受修改ID
        $id=$request->get('id');
        //根据ID查对应的数据
        $data=Message::findOne($id);
        //print_r($data);die;
        return $this->render('index',['model'=>$data]);
	}
    //修改用户信息
    public function actionUserinfo(){
        $model=new Message;
        $request=Yii::$app->request;
        $post=$request->post('Message');
        //print_r($post);die;
        if ($request->isPost) {
            $model->m_img = UploadedFile::getInstance($model, 'm_img');

            if ($model->m_img && $model->validate()) {
                $model->m_img->saveAs('uploads/' . $model->m_img->baseName . '.' . $model->m_img->extension);
                $post['m_img']='uploads/'.$model->m_img;
            }else{
                unset($post['m_img']);
            }
            $m_sex=$request->post('m_sex');
            $post['m_sex']=$m_sex[0];
            $model=Message::findOne($request->post('u_id'));
            //print_r($model);die;
            foreach($post as $k=>$v){
                $model->$k=$v;
            }
            //$model->isNewRecord=false;
            //print_r($model);die;
            if($model->save()){
                echo "ok";
                //$this->redirect(array('/data/user'));
            }else{
                echo "no";
            }
        }
    }
    //推荐好友
    public function actionTui(){
        //开启session
        $session=Yii::$app->session;
        $session->open();
        //获取session_id，根据ID查我推广的人
        $id=$session['u_id'];
        $query = Extension::find()->where(['extension.u_id' => $id]);
        $pages = new Pagination(['totalCount' => $query->count(),'defaultPageSize'=>1]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        //print_r($models);die;
        return $this->render('tui',[
        'models' => $models,
         'pages' => $pages,
    ]);
    }
    //我的收藏
    public function actionCollection(){
        $session=Yii::$app->session;
        $session->open();
        $id=$session['u_id'];
        //根据session_id获取我收藏的景点
        $query = (new \yii\db\Query())->select(['travel.t_name','travel.t_p_img','travel.t_content'])->from('collect')->where('collect.u_id='.$id)->join('LEFT JOIN','travel','travel.t_id=collect.t_id');
        $pages = new Pagination(['totalCount' => $query->count(),'defaultPageSize'=>1]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('collect',[
            'models' => $models,
            'pages' => $pages,
        ]);
    }
    //积分商城
    public function actionMall(){
        $data=(new \yii\db\Query())
            ->select(['present.p_id','present.p_name','present.p_name','present.p_jf','picture.p_img'])
            ->from('present')
            ->join('LEFT JOIN','picture','picture.p_id=present.p_img_p')
            ->where("p_num > 0")
            ->limit(6)
            ->all();
        //print_r($data);die;
        return $this->render('mall',['data'=>$data]);
    }
    //积分商城详细兑换页面
    public function actionDetail(){
        $request=Yii::$app->request;
        if($request->isGet){
            $id=$request->get('id');
            $data=(new \yii\db\Query())
                ->select(['present.p_id','present.p_name','present.p_name','present.p_jf','picture.p_img','present.p_num','present.p_content'])
                ->from('present')
                ->join('LEFT JOIN','picture','picture.p_id=present.p_img_p')
                ->where("present.p_id=".$id)
                ->one();
        }
        //print_r($data);die;
        return $this->render('detail',['data'=>$data]);
    }
    //认证邮箱
    public function actionAuthemail(){
        $session=Yii::$app->session;
        $session->open();
        $request=Yii::$app->request;
        $id=$request->get('id');
        $email=$request->get('email')?$request->get('email'):'';
        //生成token
        $arr=range(1,10);
        shuffle($arr);
        $token='';
        foreach($arr as $values)
        {
            $token.=$values;
        }
        $session['token']=$token;
        $token=$id.'-'.$token;
        return $this->render('authemail',['token'=>$token,'email'=>$email]);
    }
    //发送邮件
    public function actionEmail(){
        $request=Yii::$app->request;
        if($request->isGet && $request->isAjax){
            //echo "ok";die;
            $email=$request->get('email');
            $token=$request->get('token');
            $token=base64_encode(base64_encode('aaa'.$token."-".$email));
            $mail= Yii::$app->mailer->compose();
            $mail->setTo($email);
            $mail->setSubject("网易163用户");
            //$_SERVER["SERVER_ADDR"].
            $url="www.project.com/index.php?r=user/authtoken&token=".$token;
            //$text="请确认<a href='www.project.com'>".$url."</a>";
            //echo $text;die;;
            $mail->setTextBody($url);   //发布纯文字文本
            //$mail->setHtmlBody("<br>".$text."</br>");    //发布可以带html标签的文本
            if($mail->send()) {
                echo 1;
            }
        }
    }
    //邮箱绑定 验证token
    public function actionAuthtoken(){
        $session=Yii::$app->session;
        $session->open();
        $request=Yii::$app->request;

        if($request->isGet){
            //echo "aa";die;
            //$token=base64_encode(base64_encode('aaa').base64_encode($id.$token));
            $token=$request->get('token');
            $token=str_replace('aaa','',base64_decode(base64_decode($token)));
            //$token=base64_decode($token);
            $token=explode('-',$token);
            //print_r($token)."<br>";
            //echo $session['token'];die;

            if($session['token']==$token[1]){
                unset($session['token']);
                $model=Message::findOne($token[0]);
                $model->m_email=$token[2];
                //$model->isNewRecord=false;

                if($model->save()){
                    $string="成功！";
                }else{
                    $string="失败！<a href='www.project.com/index.php?r=user/authemail&email=".$token[2]."'>请重新获取验证码";
                }
            }else{
                $string="失败！<a href='http://www.project.com/index.php?r=user/authemail&email=".$token[2]."'><font color='blue'>请重新获取验证码</font>";
            }
            return $this->render('authemails',['string'=>$string]);
        }
    }
    //修改邮箱
    public function actionUpdates(){
        $request=Yii::$app->request;
        if($request->isGet) {
            $email = $request->get('email');
        }
        return $this->render('update',['email'=>$email]);
    }
    //添加兑换记录
    public function actionAddlog(){
        $session=Yii::$app->session;
        $session->open();
        $request=Yii::$app->request;
        $get=$request->get();
        unset($get['r']);
        $get['l_time']=date('Y-m-d');
        $get['u_id']=$session['u_id'];
        $model=new GoodsLog;
        $model->setAttributes($get);
        $model->isNewRecord=true;
        if($model->save()){
            echo 1;
        }else{
            echo 0;
        }
    }
}