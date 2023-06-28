<?php

namespace App\Http\Livewire;

use App\Events\CreateMarkerEvent;
use App\Interfaces\MarkerRepositoryInterface;
use Kolirt\Openstreetmap\Facade\Openstreetmap;
use Livewire\Component;

class CreateMarker extends Component
{
    public string $lat;
    public string $lng;

    protected $rules = [
        'lat' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
        'lng' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function addMarker(MarkerRepositoryInterface $markerRepository): void
    {
        $this->validate();

        if (Openstreetmap::reverse($this->lat, $this->lng)) {
            if ($markerRepository->getMarkerByLatLng($this->lat, $this->lng)) {
                $this->addError('error', 'Marker already exist');
            } else {
                if(!$markerRepository->createMarker($this->lat, $this->lng)) {
                    $this->addError('error', 'Creating error');
                }
            }
        } else {
            $this->addError('error', 'Not valid data');
        }
    }

    public function render()
    {
        return view('livewire.create-marker');
    }
}
