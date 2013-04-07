<?php

    class on
    {
        private static $oninit = array();
        public static function init($callback)
        {
            self::$oninit[] = $callback;
        }

        public static function onInit()
        {
            foreach (self::$oninit as $c) {
                $c();
            }
        }
    }
?>