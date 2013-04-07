<?php
    
    class PageErr extends Page
    {
        private $c, $t;
        function __construct($code, $title)
        {
            $this->c = $code;
            $this->t = $title;
        }

        public function render()
        {
            header("HTTP/1.1 " . $this->c . " " . $this->t);
            if (PageMgr::getLoader()->exists("@err/".$this->c.".html"))
                return PageMgr::getTwig()->render("@err/".$this->c.".html");
            return 'Something went wrong...<br><div class="muted"><i><small>To change this page edit err/'.$this->c.'.html</small></i></div>';
        }

        public function getTitle()
        {
            return ($this->c . " " . $this->t);
        }
    }

    /**
    * 
    */
    class ErrHandler extends PageHandler
    {
        private static $terms = array(
            "401" => "Bad Request",
            "401" => "Unauthorized",
            "404" => "Not Found",
        );
        public function resolvePage($name)
        {
            if (!isset(self::$terms[$name]))
                return null;
            return new PageErr($name, self::$terms[$name]);
        }
    }

    on::init(function() {
        PageMgr::getLoader()->addPath(RDIR."err", "err");
        PageReg::registerHandler(new ErrHandler(), "err");
    });
?>