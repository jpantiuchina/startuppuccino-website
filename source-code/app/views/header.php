<?php

    
    if(!defined("RELATIVE_PATH")){
        define("RELATIVE_PATH", "..");
    }

    // Set menu items

    $menu = [];
    $submenu = [];

    if ($userLogged){


        $menu = [
            
            [
                "label" => "Home",
                "link" => RELATIVE_PATH."/"
            ],
            [
                "label" => "Ideas",
                "link" => RELATIVE_PATH."/ideas/"
            ],
            [
                "label" => "Community",
                "link" => RELATIVE_PATH."/people/"
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
                "link" => RELATIVE_PATH."/settings/"
            ],
            [
                "label" => "Logout",
                "link" => RELATIVE_PATH."/logout/"
            ]

        ];

    } else {

        $menu = [

            [
                "label" => "About",
                "link" => RELATIVE_PATH."/about/"
            ],
            [
                "label" => "Login",
                "link" => RELATIVE_PATH."/login/"
            ],
            [
                "label" => "Register",
                "link" => RELATIVE_PATH."/register/"
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

    // Set template name and variables
    
    $template_file = "page__header.twig";

    $template_variables = [
                'sess' => $_SESSION,
                'userLogged' => $userLogged,
                'menu' => $menu,
                'submenu' => $submenu,
                'rel_path' => RELATIVE_PATH
            ];


    // Render the template
    require_once '_Twig_Loader.php';
    echo (new Twig_Loader())->render($template_file, $template_variables);

?>