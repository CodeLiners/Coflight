<?php

    abstract class Module
    {
        
        private static $all = array();
        public $moduleDir;

        function __construct()
        {
            # code...
        }

        public function preLoad() {}
        public function load() {}
        public function postLoad() {}

        public static function loadAll($coflight)
        {
            $dir = dir(RDIR."modules");
            while( $d = $dir->read()) {
                if ($d != "." && $d != "..") {
                    $moduleDir = RDIR.'modules'.DSEP.$d.DSEP;
                    require $moduleDir."main.php";
                    if (file_exists($moduleDir."template"))
                        PageMgr::getLoader()->addPath($moduleDir."template", $d);
                    /*$class = new ReflectionClass("Module".$d);
                    self::$all[$d] = $class->getConstructor()->invoke(null, $coflight);
                    self::$all[$d]->moduleDir = RDIR.'modules'.DSEP.$d.DSEP;*/
                }
            }
            /*foreach (self::$all as $m) {
                $m->preLoad();
            }
            foreach (self::$all as $m) {
                $m->load();
            }
            foreach (self::$all as $m) {
                $m->postLoad();
            }*/
        }
    }
?>