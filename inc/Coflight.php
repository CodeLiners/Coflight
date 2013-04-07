<?php
    /**
    * Coflight main class
    */
    class Coflight
    {
        public $db;
        private $pageMgr;
        public static $instance;
        function __construct()
        {
            global $cfg;
            self::$instance = $this;
            $this->pageMgr = new PageMgr();
            $this->db = new MySQL($cfg['db']['host'], $cfg['db']['user'], $cfg['db']['pass'], $cfg['db']['db']);
            date_default_timezone_set('UTC');
        }

        public function run()
        {
            
            Module::loadAll($this);

            $n = "";
            if (isset($_GET['p']))
                $n = $_GET['p'];
            $p = PageReg::resolvePage($n);

            $this->pageMgr->content = $p->render();
            $this->pageMgr->title = $p->getTitle();

            $this->pageMgr->render();
        }
    }
?>
