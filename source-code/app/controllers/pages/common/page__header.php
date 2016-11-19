<?php

    // Set menu items

    $menu = [];
    $submenu = [];

    if ($userLogged){


        $menu = [
            
            [
                "label" => "Home",
                "link" => ""
            ],
            [
                "label" => "Startups",
                "link" => "startups/"
            ],
            [
                "label" => "Community",
                "link" => "people/"
            ],
            [
                "label" => "Search",
                "link" => "#",
                "link_class" => "search_trigger_button"
            ]

        ];


        $submenu = [
            
            [
                "label" => "Settings",
                "link" => "settings/"
            ],
            [
                "label" => "Logout",
                "link" => "logout/"
            ]

        ];

    } else {

        $menu = [

            [
                "label" => "About",
                "link" => "about/"
            ],
            [
                "label" => "Login",
                "link" => "login/"
            ],
            [
                "label" => "Register",
                "link" => "register/"
            ]

        ];

    }

    // Set the active menu item
    // To be improved (e.g. do check on the links)
    if(isset($currentPage)){
        for ($i=0, $l=count($menu); $i < $l; $i++) { 
            if( strtolower($menu[$i]['label']) == $currentPage ){
                $menu[$i]["active_class"] = "menu_link--active";
            }
        }
    }


    // Add variables to template
    $template_variables['sess'] = $_SESSION;
    $template_variables['userLogged'] = $userLogged;
    $template_variables['menu'] = $menu;
    $template_variables['submenu'] = $submenu;

    if ( $_SERVER['HTTP_HOST'] === "localhost" ) {
        $template_variables['website_url'] = "http://localhost/startuppuccino-website/source-code/";
    } else {
        $template_variables['website_url'] = "http://startuppuccino.com/";
    }

?>