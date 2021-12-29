<?php

require(__DIR__ . "/../config/ftp_config.php");

class ftp_connect
{

    private $ftp_conn=null;


    public function __construct()
    {
        $this->ftp_conn = ftp_connect(ftp_config::$ftphost, ftp_config::$ftpport);
        ftp_login($this->ftp_conn, ftp_config::$ftpusername, ftp_config::$ftppassword);
        ftp_pasv($this->ftp_conn, true);
    }

    public function __destruct()
    {
        ftp_close($this->ftp_conn);
    }

    public function isConnected(): bool
    {
        return $this->ftp_conn !== null;
    }

    public function getConnection()
    {
        return $this->ftp_conn;
    }

    public function close(): bool
    {
        if ($this->ftp_conn !== null) {
            ftp_close($this->ftp_conn);
            return true;
        }
        return false;
    }


}