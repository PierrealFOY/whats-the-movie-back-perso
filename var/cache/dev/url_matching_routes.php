<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/api/movies' => [
            [['_route' => 'app_api_movie_list', '_controller' => 'App\\Controller\\Api\\MovieController::list'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'app_api_movie_add', '_controller' => 'App\\Controller\\Api\\MovieController::add'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/movies/game' => [[['_route' => 'app_api_movie_RandomMoviesGame', '_controller' => 'App\\Controller\\Api\\MovieController::RandomMoviesGame'], null, ['GET' => 0], null, false, false, null]],
        '/api/users' => [
            [['_route' => 'app_api_user_list', '_controller' => 'App\\Controller\\Api\\UserController::list'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'app_api_user_add', '_controller' => 'App\\Controller\\Api\\UserController::add'], null, ['POST' => 0], null, false, false, null],
        ],
        '/user' => [[['_route' => 'app_user', '_controller' => 'App\\Controller\\UserController::index'], null, null, null, false, false, null]],
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/api/(?'
                    .'|movies/([^/]++)(*:30)'
                    .'|users/([^/]++)(?'
                        .'|(*:54)'
                    .')'
                .')'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:94)'
                    .'|wdt/([^/]++)(*:113)'
                    .'|profiler/([^/]++)(?'
                        .'|/(?'
                            .'|search/results(*:159)'
                            .'|router(*:173)'
                            .'|exception(?'
                                .'|(*:193)'
                                .'|\\.css(*:206)'
                            .')'
                        .')'
                        .'|(*:216)'
                    .')'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        30 => [[['_route' => 'app_api_movie_show', '_controller' => 'App\\Controller\\Api\\MovieController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        54 => [
            [['_route' => 'app_api_user_show', '_controller' => 'App\\Controller\\Api\\UserController::show'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'app_api_user_edit', '_controller' => 'App\\Controller\\Api\\UserController::edit'], ['id'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'app_api_user_delete', '_controller' => 'App\\Controller\\Api\\UserController::delete'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        94 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        113 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        159 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        173 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        193 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception_panel::body'], ['token'], null, null, false, false, null]],
        206 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception_panel::stylesheet'], ['token'], null, null, false, false, null]],
        216 => [
            [['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
