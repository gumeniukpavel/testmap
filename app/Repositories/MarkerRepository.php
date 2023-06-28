<?php

namespace App\Repositories;

use App\Console\Commands\DeleteMarkerCommand;
use App\Events\CreateMarkerEvent;
use App\Events\DeleteMarkerEvent;
use App\Interfaces\MarkerRepositoryInterface;
use App\Jobs\DeleteMarkerJob;
use App\Models\Marker;
use Illuminate\Support\Facades\Log;

class MarkerRepository implements MarkerRepositoryInterface
{
    public function getAllMarkers()
    {
        return Marker::query()->get();
    }

    public function getMarkerById($markerId)
    {
        return Marker::query()->findOrFail($markerId);
    }

    public function deleteMarker(Marker $marker): void
    {
        $params = [
            'lat' => $marker->lat,
            'lng' => $marker->lng
        ];

        Marker::destroy($marker->id);

        event(new DeleteMarkerEvent($params));
    }

    public function createMarker(string $lat, string $lng): bool
    {
        try {
            $marker = new Marker();
            $marker->lat = $lat;
            $marker->lng = $lng;
            $marker->save();

            event(new CreateMarkerEvent([
                'lat' => $lat,
                'lng' => $lng
            ]));

            dispatch(new DeleteMarkerJob($marker->id))->delay(now()->addMinute());

            return true;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return false;
        }
    }

    public function getMarkerByLatLng(string $lat, string $lng): bool
    {
        return Marker::query()
            ->where('lat', $lat)
            ->where('lng', $lng)
            ->exists();
    }
}
