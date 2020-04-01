<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\ApiController;
use App\Models\ActivityLog;

class ActivityController extends ApiController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return self::success_responses(ActivityLog::with('user')->get());
    }
}