<?php
    class DBUser extends User {
        private $data;

        function __construct($data = null) {
            $this->data = $data;
        }

        // TODO: Make more dynamic
        public function hasPermission($name)
        {
            $permreq = array(
                "newpage" => "writer",
                "editpage" => "writer",
                "adduser" => "guest",
                "edituser" => "admin",
                "delpage" => "writer",
                "listpages" => "writer"
            );

            $req = $permreq[$name];

            if ($req != "guest" and $this->data == null)
                return false;

            switch ($req) {
                case 'guest':
                    return $this->data == null;
                case 'user':
                    if ($this->data->permissions == "user")
                        return true;
                case 'writer':
                    if ($this->data->permissions == "writer")
                        return true;
                case 'admin':
                    if ($this->data->permissions == "admin")
                        return true;
            }
        }

        public function getName()
        {
            if ($this->data == null)
                return "guest";
            else
                return $this->data->name;
        }
    }

    class DBUserHandler implements IUserHandler {
        private $current;

        function __construct() {
            session_start();
            if (!isset($_SESSION['coflight']))
                $_SESSION['coflight'] = array("loggedin" => false, "name" => "");
            if ($_SESSION['coflight']['loggedin']) {
                $res = Coflight::$instance->db->query("SELECT * FROM ".DB_PREF."users WHERE name = '".sql_escape($_SESSION['coflight']['name'])."'");
                $this->current = new DBUser($res->fetchObject());
            } else {
                $this->current = new DBUser();
            }
        }

        public function getCurrentUser() {
            return $this->current;
        }

        public function exists($name)
        {
            $res = Coflight::$instance->db->query("SELECT * FROM ".DB_PREF."users WHERE name = '".sql_escape($name)."'");
            return ($t = $res->fetchObject() ? true : false);
        }
    }

    Usersys::setHandler(new DBUserHandler());
    $cu = User::getCurrent();
    if ($cu->getName() == "guest") {
        $p = explode("/", PAGE);
        if (startsWith($p[0], "user:")) {
            if (isset($p[1]))
                $rlink = "/".$p[1];
            else 
                $rlink = "";
        } else {
            $rlink = "/".urlencode(PAGE);
        }
        Coflight::$instance->pageMgr->addNavRight(array(
            "title" => "Login",
            "href" => "user:login".$rlink,
            "type" => "internal",
            "active" => (startsWith(PAGE, "user:login/") or PAGE == "user:login")
        ));
        if ($cu->hasPermission("adduser"))
            Coflight::$instance->pageMgr->addNavRight(array(
                "title" => "Sign up",
                "href" => "user:register".$rlink,
                "type" => "internal",
                "active" => (startsWith(PAGE, "user:register/") or PAGE == "user:register")
            ));
    } else {
        Coflight::$instance->pageMgr->addNavRight(array(
            "title" => "Logged in as ".$cu->getName(),
            "type" => "internal",
            "sub" => array(
                array(
                    "href" => "user:logout",
                    "title" => "Logout",
                    "type" => "internal"
                )
            )
        ));
    }

    include RDIR."modules".DSEP."DBUser".DSEP."pages.php";
?>