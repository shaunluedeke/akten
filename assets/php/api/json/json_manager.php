<?php


class json_manager
{

    private static $dirname = __DIR__ . "/files/";
    private static $filename;
    function __construct($filename)
    {
        self::$filename=$filename.".php";
    }
    public function createFile($name){
            $file = fopen(self::$dirname.self::$filename, "w") or die("Unable to open file!");
            $txt = "<?php\n";
            fwrite($file,$txt);
            $jsonname=json_encode($name);
            $txt = "echo('".$jsonname."');\n";
            fwrite($file,$txt);
             $txt = "?>";
             fwrite($file,$txt);
            fclose($file);
    }
    public function deleteFile(){
        $file = self::$dirname.self::$filename;
        if (file_exists($file)) {
            unlink($file);
        }
    }
    public function getAllJSONFiles(): array
    {
        $json_php_dirs = array(__DIR__ . "/files/");
        $php_file_ext = array("php");
        require_once(__DIR__ . '/../divscan/scan.php');
        return (scanDir::scan($json_php_dirs, $php_file_ext));
    }
    public static function getDirname(): string
    {
        return self::$dirname;
    }
}