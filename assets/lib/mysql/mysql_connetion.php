<?php
require(__DIR__ . "/../config/db_config.php");

class mysql_connetion
{
    private $link = null;

    public function connect(): bool
    {
        if ($this->link === null) {
            $this->link = mysqli_connect(db_config::$mysqlhost, db_config::$mysqlusername, db_config::$mysqlpassword, db_config::$mysqldatabase, db_config::$mysqlport);
            if (mysqli_connect_errno()) {
                return false;
            }
        }
        return false;
    }

    public function getLink()
    {
        if ($this->link === null) {
            $this->connect();
        }
        return $this->link;
    }

    public function disconnect(): bool
    {
        if ($this->link !== null) {
            mysqli_close($this->link);
            return true;
        }
        return false;

    }

    public function query($query): bool
    {
        if ($this->link === null) {
            $this->connect();
        }
        if ($this->link !== null) {
            if (mysqli_query($this->link, $query) === TRUE) {
                return true;
            }
        }
        return false;
    }

    public function result($query)
    {
        if ($this->link === null) {
            $this->connect();
        }
        if ($this->link !== null) {
            if ($result = mysqli_query($this->link, $query)) {
                return $result;
            }
        }
        return null;
    }

    public function count($query): int
    {
        if ($this->link === null) {
            $this->connect();
        }
        if ($this->link !== null) {
            if ($result = mysqli_query($this->link, $query)) {
                return mysqli_num_rows($result);
            }
        }
        return 0;
    }
}