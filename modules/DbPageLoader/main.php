<?php
    /**
    * DbPageLoader class
    */
    class ModuleDbPageLoader extends Module
    {
        function __construct()
        {
        }

        public function init()
        {
            PageReg::registerHandler(new DbHandler());
        }
    }

    /**
    * DB Page Handler
    */
    class DbHandler extends PageHandler
    {
        function __construct() {}

        public function resolvePage($name)
        {
            $res = Coflight::$instance->db->query("SELECT * FROM ".DB_PREF."pages WHERE name = '".sql_escape($name)."'");

            if ($p = $res->fetchObject()) {
                return new DBPage($p);
            }

            return null;
        }
    }

    /**
    * Database Page class
    */
    class DBPage extends Page
    {
        private $datares;
        function __construct($res)
        {
            $this->datares = $res;
        }

        public function render()
        {
            return PageMgr::getTwig()->render("@DbPageLoader/page.html", 
                array(
                    "page" => $this->datares
                )
            );
        }

        public function getTitle()
        {
            return $this->datares->title;
        }
    }

    include RDIR."modules".DSEP."DbPageLoader".DSEP."pagemanager.php";
    include RDIR."modules".DSEP."DbPageLoader".DSEP."navi.php";

    $m = new ModuleDbPageLoader();
    $m->init();
?>