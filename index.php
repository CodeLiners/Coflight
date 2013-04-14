<?php
    /**
    * The CMS by CodeLiners - The Open Source Coding group
    * 
    */

    define("COFLIGHT", true);
    define("COFLIGHT_VER", "0.1.0");
    define('DSEP', DIRECTORY_SEPARATOR);
    define('RDIR', dirname(__FILE__).DSEP);
    
    function startsWith($haystack, $needle)
    {
        return !strncmp($haystack, $needle, strlen($needle));
    }

    function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    require RDIR.'config.php';
    global $cfg;
    define("DB_PREF", $cfg['db']['tabprefix']);

    require RDIR.'on.php';

    $dir = dir(RDIR.'inc');
    while ($d = $dir->read()) {
        if ($d != '.' and $d != '..') {
            include RDIR.'inc'.DSEP.$d;
        }
    }
    try {
        $c = new Coflight();
        $dir = dir(RDIR.'inc_secondary');
        while ($d = $dir->read()) {
            if ($d != '.' and $d != '..') {
                include RDIR.'inc_secondary'.DSEP.$d;
            }
        }
        on::onInit();
        
        $c->run();
    } catch (Exception $ex) {
        ?>
            <html><head><title>Err... what?</title></head><body>
            <h1>Internal Error: <?php echo $ex->getMessage(); ?></h1>
<pre><?php echo $ex->getTraceAsString(); ?></pre>
            </body></html>
        <?php
    }
        
?>