<div class="btn-group">
    @if($author->ban)
        <button data-id="{{$author->id}}" data-status="activate" data-action="ban" type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#banModal">Activate</button>
    @else
        <button data-id="{{$author->id}}" data-status="ban" data-action="ban" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#banModal">Ban</button>
    @endif
    <a href="{{ route('author', ['author' => $author->id]) }}" target="_blank" class="btn btn-primary">View Profile</a>
</div>

