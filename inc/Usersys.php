<?php
    abstract class User {
        protected $name;

        public abstract function hasPermission($name);
        public abstract function getName();

        public static function getCurrent() {
            return Usersys::getHandler()->getCurrentUser();
        }

        public static function exists($name) {
            return Usersys::getHandler()->exists($name);
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
        public function exists($nane);
    }
?>