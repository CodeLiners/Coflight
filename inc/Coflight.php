<?php
    /**
    * Coflight main class
    */
    class Coflight
    {
        private $page;
        function __construct()
        {
            $this->page = new PageMgr();
        }

        public function run()
        {
            # code...




            $this->page->render();
        }
    }
?>