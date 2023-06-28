<?php

namespace App\Jobs;

use App\Interfaces\MarkerRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteMarkerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private int $markerId;

    public function __construct(int $markerId)
    {
        $this->markerId = $markerId;
    }

    public function handle(MarkerRepositoryInterface $markerRepository): void
    {
        $marker = $markerRepository->getMarkerById($this->markerId);
        $markerRepository->deleteMarker($marker);
    }
}
