<?php

    abstract class Page
    {
        public function getTitle()
        {
            return "Unnamed";
        }

        abstract public function render();
    }


?>