<?php
  /*
   *数据库控制器
   *wpj
   */
namespace backend\controllers;

use Yii;
use app\models\Ku;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use app\models\FirmAdminuser;
use app\models\Gropshop;
use app\models\GropType;
use app\models\Imgs;
use app\models\UploadForm;

class KuController extends Controller
{
	public $enableCsrfValidation = false;
  /*
   *数据库备份
   *wpj
   */
	public function actionBeifen(){

		    $cfg_dbuser='root';
        $cfg_dbpwd='root';
        $cfg_dbname='travel';
        date_default_timezone_set('PRC');
        $filename=date("Y-m-d_H-i-s")."-".$cfg_dbname.".sql";
        $tmpFile = (dirname(__FILE__))."\\".'mysql\\'.$filename;
        exec("D:/phpStudy/MySQL/bin/mysqldump -h192.168.1.120 -u$cfg_dbuser -p$cfg_dbpwd --default-character-set=utf8 $cfg_dbname > ".$tmpFile);
        $file = fopen($tmpFile, "r+");
        fread($file,filesize($tmpFile));
        fclose($file);
        $bak=(dirname(__FILE__))."\\".'mysql\\bak.xml';
        
        $current = file_get_contents($bak);
        $current .= "\n".$filename.','.$tmpFile;
        file_put_contents($bak, $current);
        echo "<script>alert('备份成功');location.href='index.php?r=admin/index';</script>";
	}
  /*
   *数据库还原
   *wpj
   */
	public function actionHuanyuan(){

			return $this->render('huanyuan');
	}
  /*
   *数据库还原完成
   *wpj
   */
	public function actionHuanyuanh(){
		
        @$arr = isset($_POST['sqlFile']);
            if ( isset ( $_POST['sqlFile'] ) ) 
            { 
            $file_name = $_POST['sqlFile']; 
            $dbhost = "192.168.1.120";
            $dbuser = "root"; 
            $dbpass = "root"; 
            $dbname = "travel";  
            echo "<script> alert($dbhost); </script>";
            echo "<script> alert($dbuser); </script>";
            echo "<script> alert($dbpass); </script>";
            echo "<script> alert($dbname); </script>";
            set_time_limit(0); 
            $fp = @fopen($file_name, "r") or die("不能打开SQL文件 $file_name");
            mysql_connect($dbhost, $dbuser, $dbpass) or die("不能连接数据库 $dbhost");
            mysql_select_db($dbname) or die ("不能打开数据库 $dbname");
            echo "<p>正在清空数据库,请稍等....<br>"; 
            $result = mysql_query("SHOW tables"); 
            while ($currow=mysql_fetch_array($result)) 
            { 
            mysql_query("drop TABLE IF EXISTS $currow[0]"); 
            echo "清空数据表【".$currow[0]."】成功！<br>"; 
            } 
            echo "<br>恭喜你清理MYSQL成功<br>"; 
            
            echo "正在执行导入数据库操作<br>"; 
            exec("D:/phpStudy/MySQL/bin/mysql -h192.168.1.120 -u$cfg_dbuser -p$cfg_dbpwd $cfg_dbname < ".$file_name); 
            echo "<br>导入完成！"; 
            mysql_close(); 
            }
        }
}