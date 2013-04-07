<?php
    /**
    * The CMS by CodeLiners - The Open Source Coding group
    * 
    */

    define("COFLIGHT", true);
    define('DSEP', DIRECTORY_SEPARATOR);
    define('RDIR', dirname(__FILE__).DSEP);
    
    require RDIR.'on.php';

    $dir = dir(RDIR.'inc');
    while ($d = $dir->read()) {
        if ($d != '.' and $d != '..') {
            include RDIR.'inc'.DSEP.$d;
        }
    }

    $c = new Coflight();
    $dir = dir(RDIR.'inc_secondary');
    while ($d = $dir->read()) {
        if ($d != '.' and $d != '..') {
            include RDIR.'inc_secondary'.DSEP.$d;
        }
    }
    on::onInit();
    try {
        $c->run();
    } catch (Exception $ex) {
        ?>
            <html><head><title>Err... what?</title></head><body>
            <h1>Internal Error</h1>
<pre><?php echo $ex->getTraceAsString(); ?></pre>
            </body></html>
        <?php
    }
        
?>