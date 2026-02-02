<?php

namespace App\Exceptions;

use Throwable;
use App\Traits\ApiResponser;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                return $this->handleApiException($request, $e);
            }
        });
    }

    /**
     * Handle API exceptions
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleApiException($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            return $this->validationErrorResponse(
                $exception->validator->errors()->getMessages(),
                'Data yang diberikan tidak valid'
            );
        }

        if ($exception instanceof ModelNotFoundException) {
            $modelName = strtolower(class_basename($exception->getModel()));
            return $this->notFoundResponse("Data {$modelName} tidak ditemukan");
        }

        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticatedResponse('Silakan login terlebih dahulu');
        }

        if ($exception instanceof AuthorizationException) {
            return $this->unauthorizedResponse('Tidak memiliki izin untuk aksi ini');
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse('Metode HTTP tidak diizinkan', 405);
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->notFoundResponse('URL yang diminta tidak ditemukan');
        }

        if ($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }

        // Handle unexpected exceptions
        if (config('app.debug')) {
            return $this->errorResponse(
                $exception->getMessage(),
                500,
                [
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTrace()
                ]
            );
        }

        return $this->errorResponse('Terjadi kesalahan pada server', 500);
    }
}
