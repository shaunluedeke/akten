<?php
class rest{
    public function sonderzeichenentfernen($string)
    {
        return str_replace(array("ä", "ü", "ö", "Ä", "Ü", "Ö", "ß", "´"),
            array("&auml;", "&uuml;", "&ouml;", "&Auml;", "&Uuml;", "&Ouml;", "&szlig;", ""), $string);

    }
    public function sonderzeichenhinzufügen($string)
    {
        return str_replace(array("&auml;", "&uuml;", "&ouml;", "&Auml;", "&Uuml;", "&Ouml;", "&szlig;", "´"),
            array("ä", "ü", "ö", "Ä", "Ü", "Ö", "ß", ""), $string);
    }

}