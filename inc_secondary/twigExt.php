<?php
    PageMgr::getTwig()->addFilter(new Twig_SimpleFilter('reltime', function ($date) {
        return strftime("%a, %B, %e %Y - %H:%M", (int) $date); #temporary
    }));
    PageMgr::getTwig()->addFilter(new Twig_SimpleFilter('strftime', function($t, $f) {
        return strftime($f, (int) $t);
    }));
?>