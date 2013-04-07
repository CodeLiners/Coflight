<?php
    /**
    * Page class
    */
    class PageMgr {
        private $twig;
        private $content = "";
        private $nav = array();
        private $widgets = array();
        function __construct()
        {
            require_once RDIR.'Twig'.DSEP.'Autoloader.php';
            Twig_Autoloader::register();

            $loader = new Twig_Loader_Filesystem(RDIR.'template');
            $loader->addPath(RDIR.'template', "core");
            $this->twig = new Twig_Environment($loader, array());
        }

        public function render()
        {
            $foot = PageReg::resolvePage("footer");
            $foot = $foot != null ? $foot->render : "";
            echo $this->twig->render("@core/main.html", array(
                "content" => $this->content,
                "nav" => $this->nav,
                "snav" => array(),
                "footer" => $foot,
                "widgets" => $this->widgets
            ));
        }
    }
?>