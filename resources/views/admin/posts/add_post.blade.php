@push('head_scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@extends('admin._layout._layout')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Posts</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Create New Post</li>
    </ol>

    <div class="row">
        <form id="add-post-form" enctype="multipart/form-data" class="col-6" method="post" action="{{route('admin.post.store_post')}}">
            @csrf
            <div class="mb-3">
                <label for="post_photo" class="form-label">Lead Image</label>
                <input type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" id="post_photo" aria-denscribedby="emailHelp">
                @error('photo')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="post_heading" class="form-label">Heading</label>
                <input type="text" class="form-control @error('heading') is-invalid @enderror" name="heading" id="post_heading" value="{{old('heading')}}" aria-denscribedby="emailHelp">
                @error('heading')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="post_description" class="form-label">Description</label>
                <textarea id="post_description" class="form-control @error('post_description') is-invalid @enderror" name="post_description">{{old('post_description')}}</textarea>
                @error('post_description')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="select_category" class="form-label">Category</label>
                <select class="form-control @error('category_id') is-invalid @enderror" name="category_id" id="select_category">
                    <option></option>
                    @foreach($categories as $category)
                    <option @if($category->id == old('category_id')) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
                @error('category_id')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="select_tags" class="form-label">Tags</label>
                <select class="form-control @error('tags') is-invalid @enderror" name="tags[]" id="select_tags" multiple="multiple">
                    @foreach($tags as $tag)
                    <option value="{{$tag->id}}">{{$tag->name}}</option>
                    @endforeach
                </select>
                @error('tags')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="post_text" class="form-label">Text</label>
                <textarea id="post_text" class="form-control @error('text') is-invalid @enderror" name="text">{{old('text')}}</textarea>
                @error('text')
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
<script src="//cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>

<script>
$(document).ready(function () {

$('#select_category').select2({
    "placeholder" : "--select category--"
});
$('#select_tags').select2({
    "placeholder" : "--select tags--"
});

    CKEDITOR.replace( 'text' );
    CKEDITOR.config.height = 600;
// Add Post Validation  
$('#add-post-form').validate({
    "ignore": [],
    "rules": {
        "heading": {
            "required": true,
            "minlength": 5,
            "maxlength": 60
        },
        "post_description": {
            "required": true,
            "minlength": 5,
            "maxlength": 200
        },
        "category_id": {
            "required": true
        },
        "tags[]": {
            "required": true
        },
        "text": {
            "required": true
        }
    },
    "messages": {
        "heading": {
            "required": "Please enter post heading!",
            "minlength": "Post heading must be over 5 characters!",
            "maxlength": "Enter no more than 60 characters!"
        },
        "post_description": {
            "required": "Please enter post description!",
            "minlength": "Post description must be longer than 5 characters!",
            "maxlength": "Post description cannot be longer than 200 characters!"
        },
        "category_id": {
            "required": "Category is obligatory field!"
        },
        "tags[]": {
            "required": "Tags is obligatory field!"
        },
        "text": {
            "required": "Text is obligatory field!"
        }
    },
    "errorClass": "is-invalid"
});
});
</script>
@endpush



