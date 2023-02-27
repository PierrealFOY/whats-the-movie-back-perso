<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/api/games' => [
            [['_route' => 'app_api_game_list', '_controller' => 'App\\Controller\\Api\\GameController::list'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'app_api_game_add', '_controller' => 'App\\Controller\\Api\\GameController::add'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/movies' => [
            [['_route' => 'app_api_movie_list', '_controller' => 'App\\Controller\\Api\\MovieController::list'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'app_api_movie_add', '_controller' => 'App\\Controller\\Api\\MovieController::add'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/movies/games' => [[['_route' => 'app_api_movie_RandomMoviesGame', '_controller' => 'App\\Controller\\Api\\MovieController::RandomMoviesGame'], null, ['GET' => 0], null, false, false, null]],
        '/api/users' => [
            [['_route' => 'app_api_user_list', '_controller' => 'App\\Controller\\Api\\UserController::list'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'app_api_user_add', '_controller' => 'App\\Controller\\Api\\UserController::add'], null, ['POST' => 0], null, false, false, null],
        ],
        '/back-office/utilisateur' => [[['_route' => 'app_back_user_list', '_controller' => 'App\\Controller\\Back\\UserController::list'], null, null, null, false, false, null]],
        '/back-office/utilisateur/ajouter' => [[['_route' => 'app_back_user_add', '_controller' => 'App\\Controller\\Back\\UserController::add'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/' => [[['_route' => 'app_back_home', '_controller' => 'App\\Controller\\Back\\UserController::home'], null, null, null, false, false, null]],
        '/api/doc.json' => [[['_route' => 'app.swagger', '_controller' => 'nelmio_api_doc.controller.swagger'], null, ['GET' => 0], null, false, false, null]],
        '/api/doc' => [[['_route' => 'app.swagger_ui', '_controller' => 'nelmio_api_doc.controller.swagger_ui'], null, ['GET' => 0], null, false, false, null]],
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
        '/api/login_check' => [[['_route' => 'api_login_check'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/api/(?'
                    .'|games/([^/]++)(*:29)'
                    .'|movies/([^/]++)(*:51)'
                    .'|users/([^/]++)(?'
                        .'|(*:75)'
                    .')'
                .')'
                .'|/back\\-office/utilisateur/(?'
                    .'|modifier/([^/]++)(*:130)'
                    .'|([^/]++)(*:146)'
                    .'|supprimer/([^/]++)(*:172)'
                .')'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:212)'
                    .'|wdt/([^/]++)(*:232)'
                    .'|profiler/([^/]++)(?'
                        .'|/(?'
                            .'|search/results(*:278)'
                            .'|router(*:292)'
                            .'|exception(?'
                                .'|(*:312)'
                                .'|\\.css(*:325)'
                            .')'
                        .')'
                        .'|(*:335)'
                    .')'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        29 => [[['_route' => 'app_api_game_show', '_controller' => 'App\\Controller\\Api\\GameController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        51 => [[['_route' => 'app_api_movie_show', '_controller' => 'App\\Controller\\Api\\MovieController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        75 => [
            [['_route' => 'app_api_user_show', '_controller' => 'App\\Controller\\Api\\UserController::show'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'app_api_user_edit', '_controller' => 'App\\Controller\\Api\\UserController::edit'], ['id'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'app_api_user_delete', '_controller' => 'App\\Controller\\Api\\UserController::delete'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        130 => [[['_route' => 'app_back_user_edit', '_controller' => 'App\\Controller\\Back\\UserController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, true, null]],
        146 => [[['_route' => 'app_back_user_show', '_controller' => 'App\\Controller\\Back\\UserController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        172 => [[['_route' => 'app_back_user_delete', '_controller' => 'App\\Controller\\Back\\UserController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        212 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        232 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        278 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        292 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        312 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception_panel::body'], ['token'], null, null, false, false, null]],
        325 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception_panel::stylesheet'], ['token'], null, null, false, false, null]],
        335 => [
            [['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
