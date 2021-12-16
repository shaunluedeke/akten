<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$page = $_GET['page'] ?? 1;
$page = $page>0 ? ($page) : 1;
$page = $page<4?$page:3;

require_once(__DIR__ ."/../assets/php/main.php");
$main=new main();
if((file_exists("install.lock"))){header("Location: ../index.php");}
if(isset($_POST)){
    switch($page){
        case 2:{
            $fh = fopen(__DIR__ ."/../assets/lib/config/db_config.php", 'wb');
            fwrite($fh, '<?php
class db_config
{
    public static $mysqlhost = "'.$_POST["host"].'";
    public static $mysqlport = "'.$_POST["port"].'";
    public static $mysqlusername = "'.$_POST["user"].'";
    public static $mysqlpassword = "'.$_POST["pw"].'";
    public static $mysqldatabase = "'.$_POST["db"].'";
}');
            fclose($fh);
			$main->init();
            break;
        }
        case 3:{
            $r = $main->register($_POST["user"],$_POST["pw"],1);
            $re=match ($r){"#ERROR 1#"=>"Den User gibt es schon!","#ERROR 2#"=>"Es gab ein DB error!",default=>$r};
            if($re==="Den User gibt es schon!"||$re==="Es gab ein DB error!"){echo('<script>alert("'.$re.'");</script>');$page=2;}else{
				$fh = fopen("install.lock","wb");
				fwrite($fh,"finish");
				fclose($fh);
			}
            break;
        }
    }
}
require_once(__DIR__ ."/../assets/lib/template/template.php");
$template=new template();
$template->setTempFolder(__DIR__."/../assets/template/install/");
$template->parse("$page.tpl");