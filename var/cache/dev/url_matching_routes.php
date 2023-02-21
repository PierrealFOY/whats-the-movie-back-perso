<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/back-office/utilisateur' => [[['_route' => 'app_back_user_list', '_controller' => 'App\\Controller\\Back\\UserController::list'], null, null, null, true, false, null]],
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/back\\-office/utilisateur/(?'
                    .'|([^/]++)(*:44)'
                    .'|ajouter(*:58)'
                    .'|modifier/([^/]++)(*:82)'
                    .'|supprimer/([^/]++)(*:107)'
                .')'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:147)'
                    .'|wdt/([^/]++)(*:167)'
                    .'|profiler/([^/]++)(?'
                        .'|/(?'
                            .'|search/results(*:213)'
                            .'|router(*:227)'
                            .'|exception(?'
                                .'|(*:247)'
                                .'|\\.css(*:260)'
                            .')'
                        .')'
                        .'|(*:270)'
                    .')'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        44 => [[['_route' => 'app_back_user_show', '_controller' => 'App\\Controller\\Back\\UserController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        58 => [[['_route' => 'app_back_user_add', '_controller' => 'App\\Controller\\Back\\UserController::add'], [], ['POST' => 0], null, false, false, null]],
        82 => [[['_route' => 'app_back_user_edit', '_controller' => 'App\\Controller\\Back\\UserController::edit'], ['id'], ['PUT' => 0], null, false, true, null]],
        107 => [[['_route' => 'app_back_user_delete', '_controller' => 'App\\Controller\\Back\\UserController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        147 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        167 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        213 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        227 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        247 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception_panel::body'], ['token'], null, null, false, false, null]],
        260 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception_panel::stylesheet'], ['token'], null, null, false, false, null]],
        270 => [
            [['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
