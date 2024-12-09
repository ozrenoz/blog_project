<div class="btn-group-vertical">
    <div class="btn-group">
        <a class="btn btn-warning" href="{{route('admin.post.edit_post',['post' => $post])}}">Edit</a>
        @if($post->ban)
            <button data-id="{{$post->id}}" data-status="aktivirate" data-action="ban" type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#banModal">Activate</button>
        @else
            <button data-id="{{$post->id}}" data-status="banujete" data-action="ban" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#banModal">Ban</button>
        @endif
            <button data-id="{{$post->id}}" data-name="{{$post->heading}}" data-action="delete" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button>
    </div> 
     <div class="btn-group mt-2">
    
    <button data-id="{{ $post->id }}" data-action="toggle-important" type="button" class="btn {{ $post->important ? 'btn-success' : 'btn-secondary' }} toggle-important">
        {{ $post->important ? 'Unmark Important' : 'Mark Important' }}
    </button>
    <div class="btn-group">
    <button data-id="{{ $post->id }}" data-action="toggleHero" class="btn {{ $post->is_hero ? 'btn-success' : 'btn-secondary' }}">
        {{ $post->is_hero ? 'Unmark Hero' : 'Mark Hero' }}
    </button>
    <button data-id="{{ $post->id }}" data-is-hero="{{ $post->is_hero }}" data-current-order="{{ $post->hero_order }}" data-action="orderHero" class="btn btn-info">Change Hero Order</button>
    </div>
    
</div>
</div>