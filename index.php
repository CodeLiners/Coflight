<?php
    /**
    * The CMS by CodeLiners - The Open Source Coding group
    * 
    */

    define("COFLIGHT", true);
    define('DSEP', DIRECTORY_SEPARATOR);
    define('RDIR', dirname(__FILE__).DSEP);
    
    $dir = dir(RDIR.'inc');
    while ($d = $dir->read()) {
        if ($d != '.' and $d != '..') {
            include RDIR.'inc'.DSEP.$d;
        }
    }

    $c = new Coflight();
    $c->run();
?>