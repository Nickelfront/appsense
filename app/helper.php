<?php

    if (!function_exists("show")) {
        function show($data) {
            echo "<pre>";
            var_dump($data);
            echo "</pre>";            
            die();
        }
    }