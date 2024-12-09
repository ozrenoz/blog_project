@push('head_scripts')
    <link href="https://cdn.datatables.net/2.1.2/css/dataTables.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet" />
@endpush

@extends('admin._layout._layout')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Authors</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Table of all authors</li>
    </ol>
    <!-- Add New Author Button -->
    <div style="padding-bottom: 20px; display: inline-block">
        <a class="btn btn-success" href="{{ route('admin.author.add_author') }}">Add New Author</a>
    </div>
    @if(session()->has('system_message'))
        <div class="alert alert-success" role="alert">
            {{ session()->pull('system_message') }}
        </div>
    @endif
    <div class="row">
        <!-- Authors Table -->
        <table id="authors-table" class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#Id</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Ban</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<!-- Ban Author Modal -->
<div class="modal fade" id="banModal" tabindex="-1" aria-labelledby="banModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="author_ban_form">
                @csrf
                <input type="hidden" name="author_for_ban_id" value="">
                <div class="modal-header">
                    <h5 class="modal-title" id="banModalLabel">Change Author Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to <span id="author_ban_status"></span> this author?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('footer_scripts')
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$(document).ready(function() {
    let authorsDatatable = $('#authors-table').DataTable({
        "serverSide": true,
        "processing": true,
        "ajax": {
            "url": "{{ route('admin.author.datatable') }}",
            "type": "post",
            "data": {
                "_token": "{{ csrf_token() }}"
            }
        },
        "order": [[0, "asc"]],
        "columns": [
            { name: 'id', "data": "id" },
            { name: 'photo', "orderable": false, "searchable": false, "data": "photo" },
            { name: 'name', "data": "name" },
            { name: 'email', "data": "email" },
            { name: 'phone', "data": "phone" },
            { name: 'created_at', "searchable": false, "data": "created_at" },
            { name: 'ban', "searchable": false, "data": "ban" },
            { name: 'actions', "orderable": false, "searchable": false, "data": "actions" }
        ],
        "pageLength": 25,
        "lengthMenu": [5, 10, 25, 50, 100]
    });

    // Open ban modal
    $('#authors-table').on('click', '[data-action="ban"]', function() {
        let id = $(this).attr('data-id');
        let status = $(this).attr('data-status');

        $('#banModal [name="author_for_ban_id"]').val(id);
        $('#banModal #author_for_ban_status').html(status);
    });

    // Submit ban form
    $('#author_ban_form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            "url": "{{ route('admin.author.change_ban_status') }}",
            "type": "post",
            "data": {
                "_token": "{{ csrf_token() }}",
                "id": $('#author_ban_form [name="author_for_ban_id"]').val()
            }
        }).done(function() {
            authorsDatatable.ajax.reload();
            toastr.success('Successfully changed author ban status.', { timeOut: 2500 });
            $('#banModal').modal('hide');
        }).fail(function() {
            toastr.error('Error changing author ban status.', { timeOut: 2500 });
        });
    });
});
</script>
@endpush


