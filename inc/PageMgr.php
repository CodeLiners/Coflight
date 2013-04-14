<?php
    /**
    * Page class
    */
    class PageMgr {
        private static $twig;
        private static $loader;
        public $content = "";
        public $title = "";
        private $nav = array();
        private $navright = array();
        private $widgets = array();
        function __construct()
        {
            require_once RDIR.'Twig'.DSEP.'Autoloader.php';
            Twig_Autoloader::register();

            self::$loader = new Twig_Loader_Filesystem(RDIR.'template');
            self::$loader->addPath(RDIR.'template', "core");
            self::$twig = new Twig_Environment(self::$loader, array());
        }

        public function render()
        {
            global $cfg;
            $foot = PageReg::resolvePage("footer", false);
            $foot = $foot != null ? $foot->render() : "";
            echo self::$twig->render("@core/main.html", array(
                "content" => $this->content,
                "nav" => $this->nav,
                "snav" => array(),
                "footer" => $foot,
                "widgets" => $this->widgets,
                "title" => $this->title,
                "project" => $cfg['project'],
                "navright" => $this->navright,
                "coflight" => array(
                    "version" => COFLIGHT_VER,
                    "link" => "https://github.com/CodeLiners/Coflight"
                )
            ));
        }

        public function setNavi($navi)
        {
            $this->nav = $navi;
        }

        public function addNavRight($entry)
        {
            $this->navright[] = $entry;
        }

        public static function getTwig() {
            return self::$twig;
        }

        public static function getLoader() {
            return self::$loader;
        }
    }
?>