<?php
    class DBUser extends User {
        private $data;

        function __construct($data) {
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
                "delpage" => "writer"
            );

            $req = $permreq[$name];

            switch ($req) {
                case 'guest':
                    return $this->data == null;
                case 'user':
                    if ($name == "user")
                        return true;
                case 'writer':
                    if ($this->data->permissions == "writer")
                        return true;
                case 'admin':
                    if ($this->data->permissions == "admin")
                        return true;
            }
        }
    }

    class DBUserHandler implements IUserHandler {
        private $current;

        function __construct() {
            session_start();
            //if (!isset())
        }

        public function getCurrentUser() {
            return $this->current;
        }
    }

    Usersys::setHandler(new DBUserHandler())
?>