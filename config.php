<?php
    global $cfg;
    $cfg = array(
        "project" => "Test Project",
        "url" => "http://localhost/",
        "path" => "coflight/",

        "db" => array(
            "host" => "localhost",
            "port" => 3306,
            "user" => "user",
            "pass" => "password",
            "db" => "coflight",
            "tabprefix" => ""
        )
    );

    if (file_exists("../coflight.conf.php"))
        include("../coflight.conf.php"); # Debug only, use to overwrite any settings of this config you dislike (mainly db settings).
?>