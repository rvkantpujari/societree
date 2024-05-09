<div wire:ignore>
    <x-select2 name="roles[]" placeholder="Select Option(s)" multiple>
        @foreach ($results as $row)
            @if ($roles->contains($row->name))
                <option value="{{$row->name}}" selected> {{$row->name}} </option>
            @else
                <option value="{{$row->name}}"> {{$row->name}} </option>
            @endif
        @endforeach
    </x-select2>
</div>