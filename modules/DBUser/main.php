<?php
    class DBUser extends User {
        public function hasPermission($name)
        {
            
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