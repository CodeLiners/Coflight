<?php
    /**
    * Coflight main class
    */
    class Coflight
    {
        public $db;
        public $pageMgr;
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

    function pageLink($page)
    {
        return "?p=".url_encode($page); // to be changed
    }

    function url_encode($url)
    {
        $url = urlencode($url);
        $url = str_replace("%3A", ":", $url);
        $url = str_replace("%2F", "/", $url);
        return $url;
    }
?>
