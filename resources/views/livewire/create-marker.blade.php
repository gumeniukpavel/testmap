<form wire:submit.prevent="addMarker">
    <div class="form-group">
        <label for="lat">Lat</label>
        <input type="text" class="form-control" id="lat" wire:model="lat" placeholder="Lat">
        @error('lat') <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>@enderror
    </div>
    <div class="form-group">
        <label for="lng">Lng</label>
        <input type="text" class="form-control" id="lng" wire:model="lng" placeholder="Lng">
        @error('lng') <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>@enderror
    </div>
    @error('error') <div class="alert alert-danger" role="alert">
        {{ $message }}
    </div>@enderror
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
