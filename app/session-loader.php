<?php

use Util\Session;

/**
 * initialize session and fill placeholders with user data
 */
function init_dashboard($header) {

    // session_start();
    $session = new Session($_SESSION);
    // show($_SESSION);
    
    $cluFirstName = $session->get('userData')['first_name'];
    $cluLastName = $session->get('userData')['last_name'];
    $cluPosition = isset($session->get('userData')['position']) ? $session->get('userData')['position'] : "Business owner";
    //TODO get employee data
    $cluAvatarSrc = "https://eu.ui-avatars.com/api/?name=$cluFirstName+$cluLastName"; // set this if avatar is NULL
    
    $header = str_replace("{clu_first_name}", $cluFirstName, $header);
    $header = str_replace("{clu_last_name}", $cluLastName, $header);
    $header = str_replace("{clu_position}", $cluPosition, $header);
    $header = str_replace("{clu_avatar}", $cluAvatarSrc, $header);
    
    echo $header;
}
