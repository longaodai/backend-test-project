<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;

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
        $exceptions->render(function (Exception $exception, Request $request) {
            $result = [
                'status', 'message', 'errors' => []
            ];
    
            if ($request->is('api/*')) {
                switch (true) {
                    case $exception instanceof NotFoundHttpException:
                        $result['status'] = Response::HTTP_NOT_FOUND;
                        $result['message'] = __('common.msg_not_found');
                        break;
                    case $exception instanceof \ErrorException:
                        $result['status'] = Response::HTTP_INTERNAL_SERVER_ERROR;
                        $result['message'] =  __('common.msg_failure_handling');
                        break;
                    case $exception instanceof ValidationException:
                        $result['status'] = Response::HTTP_BAD_REQUEST;
                        $result['message'] = __('common.msg_valid_fails');
                        $result['errors'] = $exception->validator->getMessageBag()->toArray();
                        break;
                    case $exception instanceof AuthenticationException:
                        $result['status'] = Response::HTTP_FORBIDDEN;
                        $result['message'] =  __('common.msg_auth_token_error');
                        break;
                    default:
                        Log::debug('--------------$exception failure handling-------------- ' . $exception->getMessage());
                        $result['status'] = Response::HTTP_BAD_REQUEST;
                        $result['message'] =  __('common.msg_failure_handling');
                        break;
                }
    
                Log::debug('--------------$exception-------------- ' . $exception->getMessage());
                
                return response()->json([
                    'success' => false,
                    'error' => $result['errors'],
                    'message' => $result['message'],
                    'code' => $result['status']
                ], $result['status']);
            }
        });
    })->create();
