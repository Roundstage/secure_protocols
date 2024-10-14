<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * As pilhas de middleware globais do seu aplicativo.
     *
     * Estes middleware são executados durante cada solicitação ao seu aplicativo.
     *
     * @var array
     */
    protected $middleware = [
    ];

    /**
     * Os grupos de middleware de roteamento do seu aplicativo.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [],

        'api' => [],
    ];

    /**
     * O middleware de rota do seu aplicativo.
     *
     * Estes middleware podem ser atribuídos a grupos ou usados individualmente.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'role' => \App\Http\Middleware\CheckRole::class,
    ];
}
