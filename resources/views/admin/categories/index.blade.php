@extends('admin._layout._layout')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Categories</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Table of all categories</li>
    </ol>
    <!-- Add New Category Button -->
    <div style="padding-bottom: 20px;display:inline-block">
        <a class="btn btn-success" href="{{route('admin.category.add_category')}}">Add New Category</a>
    </div>
    <!-- Reorder Categories Form -->
    <div style="display:inline-block">
        <form id="reorder_form" method="post" action="{{route('admin.category.reorder_categories')}}" style="display:none">
            @csrf
            <input name="order" value="" type="hidden" placeholder="Enter Ids in desired order">
            <button id="cancel_reordering" type="button" class="btn btn-outline-danger">Cancel</button>
            <button type="submit" class="btn btn-outline-success">Save order</button>
        </form>
    </div>
    <div style="display:inline-block">
        <button id="change_order" type="button" class="btn btn-primary">Change order</button>
    </div>
     @if(session()->has('system_message'))
                <div class="alert alert-success" role="alert">
                    {{session()->pull('system_message')}}
                </div>
     @endif
    <div class="row">
        <!-- Categories Table -->
        <table id="categories-table" class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Show On Index</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="sortable_list">
                @forelse($categories as $category)
                <tr data-id="{{$category->id}}">
                    <th scope="row">{{$category->id}}   <a style="display:none" class="handle btn btn-info">drag</a></th>
                    <td>{{$category->name}}</td>
                    <td class="w-50">{{$category->description}}</td>
                    <td>{{$category->show_on_index}}</td>
                    <td>
                        <a class="btn btn-success" href="{{route('admin.category.edit_category',['category' => $category])}}">Edit</a>
                        <button data-id="{{$category->id}}" data-name="{{$category->name}}" data-action="delete" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button>
                    </td>
                </tr>
                @empty
                    <tr>
                         <td colspan="5" class="text-center">No categories available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>



<!-- Delete Category Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form method="post" action="{{route('admin.category.delete_category')}}">
            @csrf
            <input type="hidden" name="category_for_delete_id" value="">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Da li zelite da obrisete kategoriju?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Da li ste sigurni da zelite da obrisete kategoriju?
        <p id="category_for_delete_name"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Odustani</button>
        <button type="submit" class="btn btn-primary">Obrisi kategoriju</button>
      </div>
        </form>
    </div>
  </div>
</div>

@endsection()

@push('footer_scripts')
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js" integrity="sha256-eTyxS0rkjpLEo16uXTS0uVCS4815lc40K2iVpWDvdSY=" crossorigin="anonymous"></script>
    <script>
     $(document).ready(function(){
         // Delete Category
         $('#categories-table').on('click','[data-action="delete"]',function(){
             let id = $(this).attr('data-id');
             let name = $(this).attr('data-name');
             
             $('#deleteModal [name="category_for_delete_id"]').val(id);
             $('#deleteModal p#category_for_delete_name').html(name);
         });
         // Change Categories Order
         $('#change_order').on('click',function(){
             $('#reorder_form').show();
             $('.handle').show();
             $('#change_order').hide();
         });
         
         $('#cancel_reordering').on('click',function(){
             $('#reorder_form').hide();
             $('.handle').hide();
             $('#change_order').show();
             $( "#sortable_list" ).sortable( "cancel" );
         });
         
         $('#sortable_list').sortable({
             handle:".handle",
             update: function( event, ui ) {
                 var order = $( "#sortable_list" ).sortable( "toArray",{
                     "attribute" : "data-id"
                 } );
                 
                 $('#reorder_form [name="order"]').val(order.join(','));
             }
         });
     });
    </script>
    
@endpush
