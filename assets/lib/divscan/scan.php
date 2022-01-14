<?php
class scanDir {

    private $directories, $files, $ext_filter;


    public function __construct($directories,$ext_filter = false) {
        $this->directories = $directories;
        $this->ext_filter = $ext_filter;
    }

    public function scan(){
        $this->verifyPaths($this->directories);
        return $this->files;
    }

    private function verifyPaths($paths): void{
        $path_errors = array();
        if(is_string($paths)){$paths = array($paths);}

        foreach($paths as $path){
            if(is_dir($path)){
                $this->directories[] = $path;
                $dirContents = $this->find_contents($path);
            } else {
                $path_errors[] = $path;
            }
        }
        if($path_errors){echo "Der Ordner existier nicht!<br />";die(print_r($path_errors,false));}
    }

    private function find_contents($dir): array
    {
        $result = array();
        $root = scandir($dir);
        foreach($root as $value){
            if($value === '.' || $value === '..') {continue;}
            if(is_file($dir.DIRECTORY_SEPARATOR.$value)){
                if(!$this->ext_filter || in_array(strtolower(pathinfo($dir . DIRECTORY_SEPARATOR . $value, PATHINFO_EXTENSION)), $this->ext_filter, true)){
                    $this->files[] = $result[] = $dir.DIRECTORY_SEPARATOR.$value;
                }
            }
        }
        return $result;
    }

    public function find_by_name($dir,$name,$txt = false){
        $root = scandir($dir);
        foreach($root as $value){
            if($value === '.' || $value === '..') {continue;}
            if(is_file($dir.DIRECTORY_SEPARATOR.$value)){
                if(strtolower(pathinfo($dir.DIRECTORY_SEPARATOR.$value)['filename'])===strtolower($name)){
                    if(!$txt && strtolower(pathinfo($dir.DIRECTORY_SEPARATOR.$value)['extension'])!=="txt"){
                        return pathinfo($dir.DIRECTORY_SEPARATOR.$value)['extension'];
                    }
                    if($txt){
                        return pathinfo($dir.DIRECTORY_SEPARATOR.$value)['extension'];
                    }
                }
            }
        }
        return null;
    }
}
?>