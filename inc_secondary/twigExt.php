<?php
    PageMgr::getTwig()->addFilter(new Twig_SimpleFilter('reltime', function ($date) {
        $editdate = new DateTime('@'.$date);
    	$currdate = new DateTime('now');
    	$diff = date_diff($currdate, $editdate);
    	$years = (int) $diff->format('%y');
    	$months = (int) $diff->format('%m');
    	$days = (int) $diff->format('%d');
    	$hours = (int) $diff->format('%h');
    	$minutes = (int) $diff->format('%i');
    	if ($years > 0) {
    		return("$years Year".(($years == 1) ? '' : 's')." and $months Month".(($months == 1) ? '' : 's')." ago");	
    	} elseif ($months > 0) {
    		return("$months Month".(($months == 1) ? '' : 's')." and $days Day".(($days == 1) ? '' : 's')." ago");
    	} elseif ($days > 0) {
    		return("$days Day".(($days == 1) ? '' : 's')." and $hours Hour".(($hours == 1) ? '' : 's')." ago");
    	} elseif ($hours > 0) {
    		return("$hours Hour".(($hours == 1) ? '' : 's')." and $minutes Minute".(($minutes == 1) ? '' : 's')." ago");
    	} elseif ($minutes > 0) {
    		return("$minutes Minute".(($minutes == 1) ? '' : 's')." ago");
    	} else {
    		return('Just now.');
    	}
    }));
    PageMgr::getTwig()->addFilter(new Twig_SimpleFilter('strftime', function($t, $f) {
        return strftime($f, (int) $t);
    }));
?>
