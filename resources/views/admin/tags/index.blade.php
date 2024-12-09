@push('head_scripts')
<link href="https://cdn.datatables.net/2.1.2/css/dataTables.dataTables.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet" />
@endpush

@extends('admin._layout._layout')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Tags</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Table of all tags</li>
    </ol>
    <div style="padding-bottom: 20px;display:inline-block">
        <form id="store_tag_form">
            <input type="text" name="name" value="" placeholder="Enter tag name">
            <button class="btn btn-success" type="submit">Add new tag</button>
        </form>
    </div>
    @if(session()->has('system_message'))
    <div class="alert alert-success" role="alert">
        {{session()->pull('system_message')}}
    </div>
    @endif
    <div class="row">
        <!-- Tags Table -->
        <table id="tags-table" class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="sortable_list">

            </tbody>
        </table>

    </div>
</div>



<!-- Edit Tag Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="tag_edit_form">
               <!-- @csrf -->
                <input type="hidden" name="tag_for_edit_id" value="">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Da li zelite da izmenite naziv taga?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <input type="text" name="name" value="">
                   <button class="btn btn-success" type="submit">Edit tag name</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Odustani</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Tag Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="tag_delete_form">
               <!-- @csrf -->
                <input type="hidden" name="tag_for_delete_id" value="">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Da li zelite da obrisete tag?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Da li ste sigurni da zelite da obrisete tag?
                    <p id="tag_for_delete_name"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Odustani</button>
                    <button type="submit" class="btn btn-primary">Obrisi tag</button>
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
$(document).ready(function () {
//datatable
let tagsDataTable = $('#tags-table').DataTable({
    "serverSide": true,
    "processing": true,
    "ajax": {
        "url": "{{route('admin.tag.datatable')}}",
        "type": "post",
        "data": {
            "_token": "{{csrf_token()}}"
        }
    },
    "order": [[0, "asc"]],
    "columns": [
        {name: 'id', "data": "id"},
        {name: 'name', "data": "name"},
        {name: 'created_at', "searchable": false, "data": "created_at"},
        {name: 'actions', "orderable": false, "searchable": false, "data": "actions"}
    ],
    "pageLength": 25,
    "lengthMenu": [5, 10, 25, 50, 100]
});
//store new tag
$('#store_tag_form').on('submit',function(e){
    e.preventDefault();
    $.ajax({
        "url" : "{{route('admin.tag.store')}}",
        "type" : "post",
        "data" : {
            "_token" : "{{csrf_token()}}",
            "name" : $('#store_tag_form [name="name"]').val()
        }
    }).done(function(){
        tagsDataTable.ajax.reload();
        toastr.success('Successfuly added new tag.' ,{timeOut: 2500});
    }).fail(function(){
        toastr.error('Error adding new tag.' ,{timeOut: 2500});
    });
});
    
    
//open delete tag modal
$('#tags-table').on('click','[data-action="delete"]',function(){
 let id = $(this).attr('data-id');
 let name = $(this).attr('data-name');
     
 $('#deleteModal [name="tag_for_delete_id"]').val(id);
 $('#deleteModal p#tag_for_delete_name').html(name);
 });
 
 //submit delete form tag
 $('#tag_delete_form').on('submit',function(e){
     e.preventDefault();
     $.ajax({
        "url" : "{{route('admin.tag.delete')}}",
        "type" : "post",
        "data" : {
            "_token" : "{{csrf_token()}}",
            "id" : $('#tag_delete_form [name="tag_for_delete_id"]').val()
        }
    }).done(function(){
        tagsDataTable.ajax.reload();
        toastr.success('Successfuly deleted tag.' ,{timeOut: 2500});
        $('#deleteModal').modal('hide');
    }).fail(function(){
        toastr.error('Error deleting tag.' ,{timeOut: 2500});
    });
 });
 
 //open edit modal
 $('#tags-table').on('click','[data-action="edit"]',function(){
 let id = $(this).attr('data-id');
 let name = $(this).attr('data-name');
     
 $('#editModal [name="tag_for_edit_id"]').val(id);
 $('#editModal [name="name"]').val(name);
 });

//submit edit form tag
 $('#tag_edit_form').on('submit',function(e){
     e.preventDefault();
     $.ajax({
        "url" : "{{route('admin.tag.edit')}}",
        "type" : "post",
        "data" : {
            "_token" : "{{csrf_token()}}",
            "id" : $('#tag_edit_form [name="tag_for_edit_id"]').val(),
            "name" : $('#tag_edit_form [name="name"]').val()
        }
    }).done(function(){
        tagsDataTable.ajax.reload();
        toastr.success('Successfuly edited tag.' ,{timeOut: 2500});
        $('#editModal').modal('hide');
    }).fail(function(){
        toastr.error('Error editing tag.' ,{timeOut: 2500});
    });
 });

});
</script>

@endpush

