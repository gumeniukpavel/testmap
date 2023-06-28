<?php

namespace App\Http\Controllers;

use App\Http\Resources\MarkerResource;
use App\Interfaces\MarkerRepositoryInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(MarkerRepositoryInterface $markerRepository)
    {
        $markers = MarkerResource::collection($markerRepository->getAllMarkers())->toArray(\request());
        return view('app', ['markers' => $markers]);
    }
}
