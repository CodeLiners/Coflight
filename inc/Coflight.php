<?php
    /**
    * Coflight main class
    */
    class Coflight
    {
        private $pageMgr;
        function __construct()
        {
            $this->pageMgr = new PageMgr();
        }

        public function run()
        {
            
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