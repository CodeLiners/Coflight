<?php
    class PageListDBPages extends Page {
        
        private $pageid;

        function __construct($pageid = 1) {
            $this->pageid = $pageid;
        }

        public function getTitle()
        {
            return "List pages";
        }

        public function render()
        {
            $sta = ($this->pageid - 1) * 20;
            $count = Coflight::$instance->db->query("SELECT COUNT(id) FROM ".DB_PREF."pages")->fetchArray();
            $count = $count[0];
            $count = ceil($count / 20);
            if ($count == 0)
                $count = 1;
            $res = Coflight::$instance->db->query("SELECT * FROM ".DB_PREF."pages LIMIT $sta, 20");
            $pagelist = array();
            while ($el = $res->fetchObject())
                $pagelist[] = $el;
            return PageMgr::getTwig()->render("@DbPageLoader/list.html", array(
                "currentPage" => $this->pageid,
                "pageCount" => $count,
                "pages" => $pagelist
            ));
        }
    }

    class DBAdmPageHandler extends PageHandler {

        public function resolvePage($name)
        {
            $data = explode("/", $name);
            switch ($data[0]) {
                case 'list':
                    if (isset($data[1]))
                        $id = (int) $data[1];
                    else
                        $id = 1;
                    return new PageListDBPages($id);
                default:
                    return null;
            }
        }

    }

    PageReg::registerHandler(new DBAdmPageHandler(), "dbpageadm");
?>