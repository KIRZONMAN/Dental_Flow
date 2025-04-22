<?php
// app/Http/Controllers/ApiBD/RolApiController.php

namespace App\Http\Controllers\ApiBD;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Contracts\RolServiceInterface;

class RolApiController extends Controller
{
    public function __construct(private RolServiceInterface $service) {}

    public function index(): JsonResponse
    {
        return response()->json($this->service->all());
    }
}
