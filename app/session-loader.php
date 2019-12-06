<?php

/**
 * initialize session and fill placeholders with user data
 */

function init_dashboard($currentUser, $header) {
    // session_start();
    // show($_SESSION);

    $cluFirstName = $currentUser->get('first_name');
    $cluLastName = $currentUser->get('last_name');
    $cluPosition = $currentUser->get('position');

    $cluAvatarSrc = "https://eu.ui-avatars.com/api/?name=$cluFirstName+$cluLastName"; // TODO set this if avatar is NULL
    if ($currentUser->get('avatar')) {
        $cluAvatarSrc = $currentUser->get('avatar');
    }

    $header = str_replace("{clu_first_name}", $cluFirstName, $header);
    $header = str_replace("{clu_last_name}", $cluLastName, $header);
    $header = str_replace("{clu_position}", $cluPosition, $header);
    $header = str_replace("{clu_avatar}", $cluAvatarSrc, $header);
    
    echo $header;
}
