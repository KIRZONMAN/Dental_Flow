<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\QueryException;      // ← Añadir
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        //
    }

    public function render($request, Throwable $e)
    {
        // Capturamos cualquier SIGNAL SQLSTATE '45000' de nuestros triggers
        if (
            $e instanceof QueryException
            && isset($e->errorInfo[0])
            && $e->errorInfo[0] === '45000'
        ) {
            $mensaje = $e->errorInfo[2]; // Texto que pusiste en SET MESSAGE_TEXT

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $mensaje
                ], 400);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', $mensaje);
        }

        return parent::render($request, $e);
    }
}
