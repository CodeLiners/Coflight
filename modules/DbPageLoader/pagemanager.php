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

    /**
    * 
    */
    class PageCreateDBPage extends Page
    {
        private $page;
        function __construct($page)
        {
            $this->page = $page;
        }

        public function getTitle()
        {
            return "";
        }

        public function render()
        {
            $res = Coflight::$instance->db->query("INSERT INTO ".DB_PREF."pages (name, edit_time, edit_by, access_count, content, title)".
                "VALUES ('".sql_escape($this->page)."', ".time().", 'System', 0, '', '".sql_escape($this->page)."')");
            header("Location: ".pageLink("dbpageadm:edit/".urlencode($this->page)));
        }
    }

    /**
    * 
    */
    class PageEditDBPage extends Page
    {
        private $page;
        private $post;
        function __construct($page, $post)
        {
            $this->page = $page;
            $this->post = $post;
        }

        public function getName()
        {
            return "Edit $this->page";
        }

        public function render()
        {
            if ($this->post) {
                $res = Coflight::$instance->db->query("UPDATE ".DB_PREF."pages SET edit_time = ".time().", edit_by = '".sql_escape(User::getCurrent()->getName())."', content = '".sql_escape($_POST['content'])."', title = '".sql_escape($_POST['title'])."' WHERE name = '".sql_escape($this->page)."'");
                header("Location: ".pageLink($this->page));
            } else {
                $token = "";
                $res = Coflight::$instance->db->query("SELECT * FROM ".DB_PREF."pages WHERE name='".sql_escape($this->page)."'");
                $el = $res->fetchObject();
                return PageMgr::getTwig()->render("@DbPageLoader/edit.html", array(
                    "page" => "page",
                    "posturl" => PAGE."/post",
                    "content" => $el->content,
                    "title" => $el->title,
                    "token" => $token
                ));
            }
        }
    }

    class DBAdmPageHandler extends PageHandler {

        public function resolvePage($name)
        {
            $data = explode("/", $name);
            switch ($data[0]) {
                case 'list':
                    if (!User::getCurrent()->hasPermission("listpages"))
                        return PageReg::resolvePage("err:401");
                    if (isset($data[1]))
                        $id = (int) $data[1];
                    else
                        $id = 1;
                    return new PageListDBPages($id);
                case 'create':
                    if (!User::getCurrent()->hasPermission("newpage"))
                        return PageReg::resolvePage("err:401");
                    if (isset($_POST['page'])) {
                        $data[1] = $_POST['page'];
                    }
                    if (!isset($data[1])) {
                        header("Locaction: ".pageLink(User::getCurrent()->hasPermission("listpages") ? "dbpageadm:list" : "start"));
                        return new EmptyPage();
                    }
                    if (PageReg::resolvePage($data[1]) != null) {
                        return new PageEditDBPage($data[1], false);
                    }   
                    return new PageCreateDBPage($data[1]);
                case 'edit':
                    if (!User::getCurrent()->hasPermission("editpage"))
                        return PageReg::resolvePage("err:401");
                    if (!isset($data[1])) {
                        header("Locaction: ".pageLink(User::getCurrent()->hasPermission("listpages") ? "dbpageadm:list" : "start"));
                        return new EmptyPage();
                    }
                    if (PageReg::resolvePage($data[1]) == null) {
                        return new PageCreateDBPage($data[1]);
                    }   
                    return new PageEditDBPage($data[1], isset($data[2]) and $data[2] == "post");
                default:
                    return null;
            }
        }

    }

    PageReg::registerHandler(new DBAdmPageHandler(), "dbpageadm");
?>