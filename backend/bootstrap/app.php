<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (UnauthorizedException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => $e->getMessage()
                ], Response::HTTP_UNAUTHORIZED);
            }
        });

        $exceptions->render(function (InvalidArgumentException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => $e->getMessage()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        });

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => 'O recurso que você tentou acessar não foi localizado.'
                ], Response::HTTP_NOT_FOUND);
            }
        });

        $exceptions->render(function (Throwable $e, Request $request) {
            // num ambiente real, enviaria o erro ao sentry, ou outra ferramenta de captura.
            // aqui, ficaremos apenas com os logs do laravel.
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => "Ops! Ocorreu um erro em nosso servidor, estamos trabalhando para solucionar o mais rapido possível!"
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        });
    })->create();
