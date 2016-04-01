<?php
/**
 * 游记页面
 * wpj
 */
namespace app\models;
use Yii;
class Travels extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travels';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u_id', 't_img_p', 'c_id'], 'integer'],
            [['t_content'], 'string'],
            [['t_title', 't_times'], 'string', 'max' => 255],
            [['t_img'], 'string', 'max' => 100],
            [['t_opin'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            't_id' => 'T ID',
            'u_id' => 'U ID',
            't_img_p' => 'T Img P',
            't_title' => 'T Title',
            't_content' => 'T Content',
            'c_id' => 'C ID',
            't_times' => 'T Times',
            't_img' => 'T Img',
            't_opin' => 'T Opin',
        ];
    }
    /**
     * 查询游记
     * wpj
     */
    public function select1(){
        $select = $this->findBysql("SELECT * FROM travels")->asArray()->all();
        return $select;
    }
    /**
     * 游记删除
     * wpj
     */
    public function del(){
        $id = $_GET['id'];
        $sql  = "DELETE FROM travels WHERE t_id='$id'";
        $del = Yii::$app->db->createCommand ($sql)->execute();
        return $del;
    }
}
