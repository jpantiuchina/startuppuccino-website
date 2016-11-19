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

    // Set template name and variables
    
    $template_file = "page__header.twig";

    $template_variables = [
                'sess' => $_SESSION,
                'userLogged' => $userLogged,
                'menu' => $menu,
                'submenu' => $submenu
            ];


    // Render the template
    require_once '_Twig_Loader.php';
    echo (new Twig_Loader())->render($template_file, $template_variables);

?>