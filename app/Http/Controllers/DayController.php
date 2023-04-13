<?php

namespace App\Http\Controllers;

use App\Http\Resources\DayResource;
use App\Models\Day;
use Illuminate\Http\Request;

class DayController extends Controller
{
    public function index() {
        $days = Day::all();
        return response()->json(DayResource::collection($days));
    }
}
