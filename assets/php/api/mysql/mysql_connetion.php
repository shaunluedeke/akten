<?php
require(__DIR__ . "/../config/db_config.php");

class mysql_connetion
{
    private static $link = null;
    public static function connect(): bool{

        if(self::$link===null) {
            self::$link = mysqli_connect(db_config::$mysqlhost, db_config::$mysqlusername, db_config::$mysqlpassword, db_config::$mysqldatabase, db_config::$mysqlport);
            if (mysqli_connect_errno()) {
                return false;
            }
        }
        return false;
    }
    public static function getLink(){
        if(self::$link===null){
            self::connect();
        }
        return self::$link;
    }
    public static function disconnect(): bool {
        if(self::$link!==null) {
            mysqli_close(self::$link);
            return true;
        }
        return false;
    }
    public static function query($query): bool{
        if(self::$link===null){
            self::connect();
        }
        if((self::$link !== null) && mysqli_query(self::$link, $query) === TRUE) {
            return true;
        }
        return false;
    }
    public static function result($query): mysqli_result|bool|null
    {
        if(self::$link===null){
            self::connect();
        }
        if((self::$link !== null) && $result = mysqli_query(self::$link, $query)) {
            return $result;
        }
        return null;
    }
}