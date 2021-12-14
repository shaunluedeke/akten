<?php


class mysql_connetion
{
    private static $link = null;
    public function connect(): bool{
        require_once(__DIR__ . "/../config/db_config.php");
        $conf = new db_config();
        if(self::$link===null) {
            self::$link = mysqli_connect($conf->mysqlhost,$conf->mysqlusername, $conf->mysqlpassword, $conf->mysqldatabase, $conf->mysqlport);
            if (mysqli_connect_errno()) {
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }
    public function getLink(){
        if(self::$link===null){
            $this->connect();
        }
        return self::$link;
    }
    public function disconnect(): bool {
        if(self::$link!==null) {
            mysqli_close(self::$link);
            return true;
        }
        return false;
    }
    public function query($query): bool{
        if(self::$link===null){
            $this->connect();
        }
        return (self::$link !== null) && mysqli_query(self::$link, $query) === TRUE;
    }
    public function result($query): array|bool{
        if(self::$link===null){
            $this->connect();
        }
        if((self::$link !== null) && $result = mysqli_query(self::$link, $query)) {
            return mysqli_fetch_array($result) ?? array();
        }
        return array();
    }
    public function count($query):int{
        if(self::$link===null){
            $this->connect();
        }
        if(self::$link!==null) {
            if($result = mysqli_query(self::$link, $query)){
                return mysqli_num_rows($result);
            }
            return 0;
        }
        return 0;
    }
}