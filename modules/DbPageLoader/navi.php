<?php
    function setupNavi()
    {
        $navi = array();
        $res = Coflight::$instance->db->query("SELECT * FROM ".DB_PREF."navi WHERE parent = '' ORDER BY id");
        while ($el = $res->fetchArray()) {
            $res2 = Coflight::$instance->db->query("SELECT * FROM ".DB_PREF."navi WHERE parent = '".$el['uid']."' ORDER BY id");
            $el['sub'] = array();
            while ($el2 = $res2->fetchArray())
                $el['sub'][] = $el2;
            $navi[] = $el;
        }
        Coflight::$instance->pageMgr->setNavi($navi);
    }   
    setupNavi();
?>