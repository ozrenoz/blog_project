@extends('admin._layout._layout')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Categories</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Create New Category</li>
    </ol>
    
    <!-- Add New Category Form -->
    <div class="row">
        <form id="add-category-form" class="col-3" method="post" action="{{route('admin.category.store_category')}}">
            @csrf
            <div class="mb-3">
                <label for="category_name" class="form-label">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="category_name" value="{{old('name')}}" aria-denscribedby="emailHelp">
                @error('name')
                         <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="category_description" class="form-label">Description</label>
                <textarea id="category_description" class="form-control @error('description') is-invalid @enderror" name="description">{{old('description')}}</textarea>
                @error('description')
                         <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 form-check">
                <input name="show_on_index" value="1" @if(old('show_on_index') == 1) checked @endif type="checkbox" class="form-check-input" id="show_on_index">
                <label class="form-check-label" for="show_on_index">Show On Index</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection
<!-- Validation -->
@push('footer_scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
    
    <script>
        $(document).ready(function(){
            // Add Category Validation
            $('#add-category-form').validate({
                "rules" : {
                    "name" : {
                        "required" : true,
                        "minlength" : 3,
                        "maxlength" : 30
                    },
                    "description" : {
                        "required" : true,
                        "minlength" : 5,
                        "maxlength" : 60
                    }
                },
                "messages" : {
                    "name" : {
                        "required" : "Please enter category name!",
                        "minlength" : "Category name must be over 3 characters!",
                        "maxlength" : "Enter no more than 30 characters!"
                    },
                    "description" : {
                        "required" : "Please enter category description!",
                        "minlength" : "Category description must be longer than 5 characters!",
                        "maxlength" : "Category description cannot be longer than 60 characters!"
                    }
                },
                "errorClass" : "is-invalid"
            });
        });
    </script>
    @endpush

