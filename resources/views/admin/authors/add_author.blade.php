@push('head_scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@extends('admin._layout._layout')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Authors</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Create New Author</li>
    </ol>

    <div class="row">
        <!-- Add New Author Form -->
        <form id="add-author-form" enctype="multipart/form-data" class="col-6" method="post" action="{{route('admin.author.store_author')}}">
            @csrf
            <div class="mb-3">
                <label for="author_photo" class="form-label">Profile Photo</label>
                <input type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" id="author_photo">
                @error('photo')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="author_name" class="form-label">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="author_name" value="{{old('name')}}">
                @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="author_email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="author_email" value="{{old('email')}}">
                @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="author_phone" class="form-label">Phone</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="author_phone" value="{{old('phone')}}">
                @error('phone')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection

@push('footer_scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Validation -->
<script>
$(document).ready(function () {
    // Add Author Validation
    $('#add-author-form').validate({
        "rules": {
            "name": {
                "required": true,
                "minlength": 3,
                "maxlength": 50
            },
            "email": {
                "required": true,
                "email": true
            },
            "phone": {
                "required": true,
                "minlength": 10,
                "maxlength": 20
            }
        },
        "messages": {
            "name": {
                "required": "Please enter author name!",
                "minlength": "Author name must be over 3 characters!",
                "maxlength": "Author name cannot be longer than 50 characters!"
            },
            "email": {
                "required": "Please enter email!",
                "email": "Enter a valid email address!"
            },
            "phone": {
                "required": "Please enter phone number!",
                "minlength": "Phone number must be at least 10 characters!",
                "maxlength": "Phone number cannot be longer than 20 characters!"
            }
        },
        "errorClass": "is-invalid"
    });
});
</script>
@endpush

