<?php

    /**
    * 
    */
    class PageLogin extends Page {
        
        private $return;

        function __construct($return = "start")
        {
            $this->return = $return;
        }

        public function getTitle()
        {
            return "Login";
        }

        public function render()
        {
            if (isset($_POST['post'])) {
                $res = $res = Coflight::$instance->db->query("SELECT * FROM ".DB_PREF."users WHERE name='".sql_escape($_POST['user'])."' and pass_hash = '".sql_escape(hash("sha512", $_POST['pw']))."'");
                    if ($u = $res->fetchObject()) {
                        $_SESSION['coflight'] = array("loggedin" => true, "name" => $u->name);
                        header("Location: ".pageLink(urldecode($this->return)));
                    } else {
                        return PageMgr::getTwig()->render("@DBUser/login.html", array("posttar" => PAGE, "error" => "Invalid Username or Password"));
                    }
            } else {
                return PageMgr::getTwig()->render("@DBUser/login.html", array("posttar" => PAGE));
            }
        }
    }
    
    /**
    * 
    */
    class PageRegister extends Page {
        
        private $return;

        function __construct($return = "start")
        {
            $this->return = $return;
        }

        public function getTitle()
        {
            return "Login";
        }

        public function render()
        {
            if (isset($_POST['post'])) {
                # Check user
                $err = null;
                if (User::exists($_POST['user'])) {
                    $err = "User already exists";
                } elseif ($_POST['pw1'] != $_POST['pw2']) {
                    $err = "The passwords don't match";
                }

                if ($err == null) {
                    $res = $res = Coflight::$instance->db->query(
                        "INSERT INTO ".DB_PREF."users (name, pass_hash, email) VALUES ('".
                        sql_escape($_POST['user'])."', '".
                        sql_escape(hash("sha512", $_POST['pw1']))."', '".
                        sql_escape($_POST['mail'])."')"
                    );
                }

                if ($err != null)
                    return PageMgr::getTwig()->render("@DBUser/register.html", array(
                        "posttar" => PAGE, 
                        "error" => $err,
                        "user" => $_POST['user'],
                        "mail" => $_POST['mail']
                    )); 
                else {
                    header("Location: ".pageLink(urldecode($this->return)));
                }   
            } else {
                return PageMgr::getTwig()->render("@DBUser/register.html", array("posttar" => PAGE));
            }
        }
    }

    /**
    * 
    */
    class PageLogout extends Page
    {
        private $return;
        function __construct($return)
        {
            $this->return = $return;
        }

        public function getName()
        {
            return "Logout";
        }

        public function render()
        {
            $_SESSION['coflight'] = array("loggedin" => false, "name" => "");
            header("Location: ".pageLink(urldecode($this->return)));
        }
    }

    class UserPageHandler extends PageHandler {

        public function resolvePage($name)
        {
            $data = explode("/", $name);
            switch ($data[0]) {
                case 'login':
                    if (isset($data[1]))
                        $return = $data[1];
                    else
                        $return = "start";
                    return new PageLogin($return);
                case 'register':
                    if (!User::getCurrent()->hasPermission("adduser"))
                        return PageReg::resolvePage("err:401");
                    if (isset($data[1]))
                        $return = $data[1];
                    else
                        $return = "start";
                    return new PageRegister($return);
                case 'logout':
                    if (isset($data[1]))
                        $return = $data[1];
                    else
                        $return = "start";
                    return new PageLogout($return);
                default:
                    return null;
            }
        }

    }
    PageReg::registerHandler(new UserPageHandler(), "user");
?>