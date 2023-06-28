<?php

namespace App\Interfaces;

use App\Models\Marker;

interface MarkerRepositoryInterface
{
    public function getAllMarkers();
    public function getMarkerById($markerId);
    public function deleteMarker(Marker $marker);
    public function createMarker(string $lat, string $lng);
    public function getMarkerByLatLng(string $lat, string $lng);
}
