<?php

class template {

    private string $template_folder = "";

    public function setTempFolder( $template_folder ): void
    {
        $this->template_folder = $template_folder;
    }

    private array $vars = array();

    public function assign( $key, $value ): void
    {
        if ( is_array( $value ) ) {
            if(!isset($this->vars[$key])) {
                $this->vars[$key] = array();
            }
            $this->vars[$key][] = $value;
            return;
        }
        $this->vars[$key] = $value;
    }


    //abrufen
    public function parse( $template_file = ""): void
    {
        if($this->template_folder !== "") {
            $template_file = $this->template_folder.$template_file;
        }
        if ( !file_exists( $template_file ) ) {
            exit( '<h1>$template_file</h1><h1>Template error</h1>' );
        }
        $content = file_get_contents($template_file);

        foreach ( $this->vars as $key => $value ) {
            $content = $this->parseContent( $key, $value, $content );
        }

        eval( '?> ' . $content . '<?php ' );
    }

    private function parseContent( $key, $value, $content ) {

        if ( is_array( $value ) ) {
            $content = $this->parseLoop($key, $value, $content);
        } else if(is_bool ( $value ) ) {
            $content = $this->parseIf($key, $value, $content);
            $content = $this->parseIfNot($key, $value, $content);
        } else {
            $content = $this->parseSingle($key, (string)$value, $content);
        }
        return $content;
    }

    private function parseLoop( $key, $value, $content ) {
        $match = $this->matchLoop($content, $key);
        if( $match === false ) {
            return $content;
        }
        $str='';
        foreach ( $value as $index ) {
            $cmatch=$match['1'];

            foreach ( $index as $k_row => $row ) {
                $cmatch = $this->parseContent( $key."_".$k_row, $row, $cmatch);
            }
            $str .= $cmatch;
        }

        return str_replace($match['0'], $str, $content);
    }


    private function parseSingle($key, $value, $string): array|string
    {
        return str_replace( "{".($key)."}", $value, $string );
    }

    private function parseIf( $variable, $data, $string ) {

        $match = $this->matchIf($string, $variable);

        if( $match === false ) {
            return $string;
        }
        if($data) {
            return str_replace( $match['0'], $match['1'], $string);
        }

        return str_replace( $match['0'], null, $string);
    }
    private function parseIfNot( $variable, $data, $string ) {

        $match = $this->matchIfNot($string, $variable);

        if( $match === false ) {
            return $string;
        }
        if(!$data) {
            return str_replace( $match['0'], $match['1'], $string);
        }

        return str_replace( $match['0'], null, $string);
    }


    private function matchLoop( $string, $variable ) {
        if ( !preg_match("|" . '{loop ' . $variable ."}(.+?)". '{/loop}' . "|s", $string, $match ) ) {
            return false;
        }

        return $match;
    }
    private function matchIf( $string, $variable ) {
        if ( !preg_match("|".'{if ' . $variable .'}(.+?)'. '{/if'. "}|s", $string, $match ) ) {
            return false;
        }

        return $match;
    }
    private function matchIfNot( $string, $variable ) {
        if ( !preg_match("|".'{if not ' . $variable .'}(.+?)'. '{/if not' . "}|s", $string, $match ) ) {
            return false;
        }

        return $match;
    }
}
?>