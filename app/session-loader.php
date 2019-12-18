<?php

use util\Template;

function init_dashboard($currentUser, $header) {
    if ($currentUser == null) {
        returnToPage("../forbidden.php");
        die();
    }
    if ($currentUser->get('user_type_id') == 1) {
        $sidebarContent = "company-dashboard.php";
    } else {
        $sidebarContent = "employee-dashboard.php";
    }

    $sidebar = Template::content("../public/dashboard/", $sidebarContent);
    
    $cluFirstName = $currentUser->get('first_name');
    $cluLastName = $currentUser->get('last_name');
    $cluPosition = $currentUser->get('position');

    $cluAvatarSrc = "https://eu.ui-avatars.com/api/?name=$cluFirstName+$cluLastName"; 
    if ($currentUser->get('avatar')) {
        $cluAvatarSrc = $currentUser->get('avatar');
    }

    $header = str_replace("{clu_first_name}", $cluFirstName, $header);
    $header = str_replace("{clu_last_name}", $cluLastName, $header);
    $header = str_replace("{clu_position}", $cluPosition, $header);
    $header = str_replace("{clu_avatar}", $cluAvatarSrc, $header);
    
    echo $header . $sidebar;
}
