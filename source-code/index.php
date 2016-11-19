<?php
  
  /**
   * Register all the routes
   */
  require __DIR__.'/app/router/dump_router.php';

  Dump_Router::route('/',[
    'controller' => "landing"
  ]);

  Dump_Router::manyRoute(['login', 
                          'register', 
                          'about', 
                          'home', 
                          'app',
                          'ideas',
                          'logout',
                          'people',
                          'player',
                          'settings',
                          'startups',
                          'marshmallow',
                          'lollipop',
                          'cake']);

  /**
   * Trigger the router and evaluate the uri path
   */
  Dump_Router::render($_SERVER['REQUEST_URI'], "./app/controllers/pages/");

?>