<?php
    abstract class User {
        protected $name;

        public abstract function hasPermission($name);

        public static function getCurrent() {
            return Usersys::getHandler()->getCurrentUser();
        }
    }

    class Usersys {
        private static $handler;
        public static function setHandler($val) {
            self::$handler = $val;
        }

        public static function getHandler() {
            return self::$handler;
        }
    }

    interface IUserHandler {
        public function getCurrentUser();
    }
?>