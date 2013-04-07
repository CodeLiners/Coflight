<?php

    class PageReg {
        
        private static $handlers = array();
        private static $pages = array();

        function __construct()
        {
            # code...
        }

        public static function resolvePage($name, $do404 = true)
        {
            if (isset(self::$pages[$name]))
                return self::$pages[$name];
            $tmp = explode(":", $name);
            if (count($tmp) > 1) {
                $ns = $tmp[0];
                $name = substr($name, strlen($ns) + 1);
            } else {
                $ns = "main";
            }
            if (isset(self::$handlers[$ns]))
                foreach (self::$handlers[$ns] as $h) {
                    $p = $h->resolvePage($name);
                    if ($p != null)
                        return $p;
                }
            if ($do404) {
                $p = self::resolvePage("err:404", false);
                if ($p != null) 
                    return $p;
            }
            return null;
        }

        public static function registerPage($name, $page)
        {
            self::$pages[$name] = $page;
        }

        public static function registerHandler($handler, $ns = "main")
        {
            if (!isset(self::$handlers[$ns])) self::$handlers[$ns] = array();
            self::$handlers[$ns][] = $handler;
        }
    }
?>