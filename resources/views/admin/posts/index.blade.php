@push('head_scripts')
    <link href="https://cdn.datatables.net/2.1.2/css/dataTables.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet" />
@endpush

@extends('admin._layout._layout')

@section('content')
<!-- postove sam ostavio da budu ordered by created_at -->
<div class="container-fluid px-4">
    <h1 class="mt-4">Posts</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Table of all posts</li>
    </ol>
    <div style="padding-bottom: 20px;display:inline-block">
        <a class="btn btn-success" href="{{route('admin.post.add_post')}}">Add New Post</a>
    </div>
     @if(session()->has('system_message'))
                <div class="alert alert-success" role="alert">
                    {{session()->pull('system_message')}}
                </div>
     @endif
    <div class="row">
        <table id="posts-table" class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#Id</th>
                    <th scope="col">Picture</th>
                    <th scope="col">Heading</th>
                    <th scope="col">Category</th>
                    <th scope="col">Tags</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Ban</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="sortable_list">
               
            </tbody>
        </table>
        
    </div>
</div>



<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="post_delete_form">
               <!-- @csrf -->
                <input type="hidden" name="post_for_delete_id" value="">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Da li zelite da obrisete vest?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Da li ste sigurni da zelite da obrisete post?
                    <p id="post_for_delete_heading"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Odustani</button>
                    <button type="submit" class="btn btn-primary">Obrisi post</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Ban Modal -->
<div class="modal fade" id="banModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="post_ban_form">
               <!-- @csrf -->
                <input type="hidden" name="post_for_ban_id" value="">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Da li zelite da promenite status posta?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Da li ste sigurni da zelite da
                    
                    <p id="post_for_ban_status"></p>post?
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Odustani</button>
                    <button type="submit" class="btn btn-primary">Promeni status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Hero Order Modal -->
<div class="modal fade" id="heroOrderModal" tabindex="-1" aria-labelledby="heroOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="hero-order-form">
                <input type="hidden" name="post_id" value="">
                <div class="modal-header">
                    <h5 class="modal-title" id="heroOrderModalLabel">Change Hero Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="order" class="form-label">Order Position</label>
                    <select name="order" class="form-control" required>
                        @for ($i = 1; $i <= 10; $i++) 
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Order</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection()

@push('footer_scripts')
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
 $(document).ready(function(){
         
    let postsDatatable = $('#posts-table').DataTable({
            "serverSide" : true,
            "processing" : true,
            "ajax" : {
                "url" : "{{route('admin.post.datatable')}}",
                "type" : "post",
                "data" : {
                    "_token" : "{{csrf_token()}}"
                }
            },
            "order" : [[5,"desc"]],
            "columns" : [
                { name: 'id',"data" : "id"},
                { name: 'picture',"orderable" : false,"searchable" : false,"data" : "picture"},
                { name: 'heading',"data" : "heading"},
                { name: 'category',"data" : "category"},
                { name: 'tags',"orderable" : false,"searchable" : false,"data" : "tags"},
                { name: 'created_at',"searchable" : false,"data" : "created_at"},
                { name: 'ban',"searchable" : false,"data" : "ban"},
                { name: 'actions',"orderable" : false,"searchable" : false,"data" : "actions"}
            ],
            "pageLength" : 25,
            "lengthMenu" : [5,10,25,50,100]
        });
            
//open delete post modal
$('#posts-table').on('click','[data-action="delete"]',function(){
let id = $(this).attr('data-id');
let name = $(this).attr('data-name');
     
$('#deleteModal [name="post_for_delete_id"]').val(id);
$('#deleteModal p#post_for_delete_heading').html(name);
});
 
//submit delete post form
$('#post_delete_form').on('submit',function(e){
 e.preventDefault();
 $.ajax({
    "url" : "{{route('admin.post.delete_post')}}",
    "type" : "post",
    "data" : {
        "_token" : "{{csrf_token()}}",
        "id" : $('#post_delete_form [name="post_for_delete_id"]').val()
    }
}).done(function(){
    postsDatatable.ajax.reload();
    toastr.success('Successfuly deleted post.' ,{timeOut: 2500});
    $('#deleteModal').modal('hide');
}).fail(function(){
    toastr.error('Error deleting post.' ,{timeOut: 2500});
});
});


$('#posts-table').on('click','[data-action="ban"]',function(){
let id = $(this).attr('data-id');
let status = $(this).attr('data-status');
     
$('#banModal [name="post_for_ban_id"]').val(id);
$('#banModal p#post_for_ban_status').html(status);
});
 
// Toggle Ban Status
$('#post_ban_form').on('submit',function(e){
 e.preventDefault();
 $.ajax({
    "url" : "{{route('admin.post.change_ban_status')}}",
    "type" : "post",
    "data" : {
        "_token" : "{{csrf_token()}}",
        "id" : $('#post_ban_form [name="post_for_ban_id"]').val()
    }
}).done(function(){
    postsDatatable.ajax.reload();
    toastr.success('Successfuly changed post ban status.' ,{timeOut: 2500});
    $('#banModal').modal('hide');
}).fail(function(){
    toastr.error('Error changing post ban status.' ,{timeOut: 2500});
});
});

 $('#posts-table').on('click', '.toggle-important', function () {
        let button = $(this);
        let postId = button.data('id');

        $.ajax({
            url: "{{ route('admin.post.toggle_important') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: postId
            },
            success: function (response) {
                if (response.status === 'ok') {
                    button.toggleClass('btn-success btn-secondary');
                    button.text(response.important ? 'Unmark Important' : 'Mark Important');
                    toastr.success('Successfully changed important status.', { timeOut: 2500 });
                }
            },
            error: function () {
                toastr.error('Error changing important status.', { timeOut: 2500 });
            }
        });
     });
  // Toggle Hero Status
    $('#posts-table').on('click', '[data-action="toggleHero"]', function () {
        let button = $(this);
        let postId = button.data('id');

        $.post("{{ route('admin.post.toggle_hero_status') }}", { id: postId, _token: "{{ csrf_token() }}" })
            .done(function (response) {
                if (response.status === 'ok') {
                    postsDatatable.ajax.reload();

                    
                    button.toggleClass('btn-success btn-secondary');
                    button.text(response.is_hero ? 'Unmark Hero' : 'Mark Hero');

                    toastr.success('Hero status updated');
                }
            }).fail(function () {
                toastr.error('Error updating hero status');
            });
    });

   // Open Change Hero Order Modal if the post is marked as hero
$('#posts-table').on('click', '[data-action="orderHero"]', function () {
    let postId = $(this).data('id');
    let currentOrder = $(this).data('current-order'); 
    let isHero = $(this).closest('tr').find('[data-action="toggleHero"]').hasClass('btn-success'); 

    if (!isHero) {
        toastr.error('This post is not marked as hero. Please mark it as hero first.', { timeOut: 2500 });
        return;
    }

    // Fetch existing orders
    $.ajax({
        url: "{{ route('admin.post.get_existing_hero_orders') }}",
        type: "GET",
        success: function (response) {
            let takenOrders = response.taken_orders;

            let orderInput = $('#heroOrderModal [name="order"]');
            orderInput.empty();

            
            for (let i = 1; i <= 10; i++) {
                let option = $('<option>', { value: i, text: i });

                
                if (i === currentOrder) {
                    option.prop('selected', true).css({ 'font-weight': 'bold', 'color': '#28a745' }); 
                } else if (takenOrders.includes(i)) {
                    option.css({ 'font-weight': 'bold', 'color': '#ff0000' }); 
                } else {
                    option.css({ 'color': '#cccccc' }); 
                }

                orderInput.append(option);
            }

            
            $('#heroOrderModal [name="post_id"]').val(postId);
            $('#heroOrderModal').modal('show');
        },
        error: function () {
            toastr.error('Error fetching hero order values', { timeOut: 2500 });
        }
    });
});

    // Submit Hero Order Form
$('#hero-order-form').on('submit', function (e) {
    e.preventDefault();

    let postId = $('#heroOrderModal [name="post_id"]').val();
    let newOrder = $('#heroOrderModal [name="order"]').val();

    $.ajax({
        url: "{{ route('admin.post.update_hero_order') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id: postId,
            hero_order: newOrder
        },
        success: function (response) {
            if (response.status === 'ok') {
                $('#heroOrderModal').modal('hide');
                toastr.success('Hero order updated successfully', { timeOut: 2500 });
                postsDatatable.ajax.reload(); 
            } else {
                toastr.error(response.message || 'Error updating hero order', { timeOut: 2500 });
            }
        },
        error: function () {
            toastr.error('Error updating hero order', { timeOut: 2500 });
        }
    });
    });
 });
    </script>
    
@endpush


