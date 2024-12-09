<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', ['App\Http\Controllers\IndexController', 'index'])->name('index');

Route::get('/contact-us', ['App\Http\Controllers\ContactController', 'contactUs'])->name('contact_us_page');
Route::post('/contact-us/form-upload', ['App\Http\Controllers\ContactController', 'formUpload'])->name('contact_us_form_upload');

Route::get('/blog', ['App\Http\Controllers\PagesController', 'blog'])->name('blog');
Route::get('/search', ['App\Http\Controllers\PagesController', 'search'])->name('search');

Route::get('/category/{category}', ['App\Http\Controllers\PagesController', 'category'])->name('category');

Route::get('/post/{post}', ['App\Http\Controllers\PostsController', 'post'])->name('post');
Route::post('store-comment', ['App\Http\Controllers\PostsController', 'storeComment'])->name('store_comment');

Route::get('/tag/{tag}', ['App\Http\Controllers\PagesController', 'tag'])->name('tag');
Route::get('/author/{author}', ['App\Http\Controllers\PagesController', 'author'])->name('author');


Route::middleware('auth')->prefix('/admin')->name('admin.')->group(function(){
    Route::get('', ['App\Http\Controllers\Admin\IndexController', 'index'])->name('index');
    Route::get('/profile', ['App\Http\Controllers\Admin\IndexController', 'profile'])->name('profile');
    Route::get('/search', ['App\Http\Controllers\Admin\AdminSearchController', 'search'])->name('search');
    
    Route::name('category.')->prefix('/categories/')->group(function(){
        Route::get('/index', ['App\Http\Controllers\Admin\CategoriesController', 'index'])->name('index');
        Route::get('/add-category', ['App\Http\Controllers\Admin\CategoriesController', 'addCategory'])->name('add_category');
        Route::post('/store-category', ['App\Http\Controllers\Admin\CategoriesController', 'store'])->name('store_category');
        Route::get('/edit-category/{category}', ['App\Http\Controllers\Admin\CategoriesController', 'edit'])->name('edit_category');
        Route::post('/update-category/{category}', ['App\Http\Controllers\Admin\CategoriesController', 'update'])->name('update_category');
        Route::post('/delete-category', ['App\Http\Controllers\Admin\CategoriesController', 'delete'])->name('delete_category');
        Route::post('/reorder-categories', ['App\Http\Controllers\Admin\CategoriesController', 'reorder'])->name('reorder_categories');
    });
    
    Route::name('post.')->prefix('/posts/')->group(function(){
        Route::get('/index', ['App\Http\Controllers\Admin\PostsController', 'index'])->name('index');
        Route::post('/ajax-posts-datatable', ['App\Http\Controllers\Admin\PostsController', 'datatable'])->name('datatable');
        Route::get('/add-post', ['App\Http\Controllers\Admin\PostsController', 'addPost'])->name('add_post');
        Route::post('/store-post', ['App\Http\Controllers\Admin\PostsController', 'store'])->name('store_post');
        Route::post('/delete-post', ['App\Http\Controllers\Admin\PostsController', 'delete'])->name('delete_post');
        Route::post('/change-ban-status', ['App\Http\Controllers\Admin\PostsController', 'changeBanStatus'])->name('change_ban_status');
        Route::post('/toggle-important', ['App\Http\Controllers\Admin\PostsController', 'toggleImportant'])->name('toggle_important');
        Route::post('/toggle-hero-status', ['App\Http\Controllers\Admin\PostsController', 'toggleHeroStatus'])->name('toggle_hero_status');
        Route::post('/update-hero-order', ['App\Http\Controllers\Admin\PostsController', 'updateHeroOrder'])->name('update_hero_order');
        Route::get('/get-existing-hero-orders', ['App\Http\Controllers\Admin\PostsController', 'getExistingHeroOrders'])->name('get_existing_hero_orders');
        Route::get('/edit/{post}', ['App\Http\Controllers\Admin\PostsController', 'edit'])->name('edit_post');
        Route::post('/update/{post}', ['App\Http\Controllers\Admin\PostsController', 'update'])->name('update_post');
        Route::post('/delete-photo/{post}', ['App\Http\Controllers\Admin\PostsController', 'editDeletePhoto'])->name('edit_delete_photo');
    });
    
    Route::name('tag.')->prefix('/tags/')->group(function(){
        Route::get('/index', ['App\Http\Controllers\Admin\TagsController', 'index'])->name('index');
        Route::post('/ajax-tags-datatable', ['App\Http\Controllers\Admin\TagsController', 'datatable'])->name('datatable');
        Route::post('/ajax-tags-store', ['App\Http\Controllers\Admin\TagsController', 'store'])->name('store');
        Route::post('/ajax-tags-delete', ['App\Http\Controllers\Admin\TagsController', 'delete'])->name('delete');
        Route::post('/ajax-tags-edit', ['App\Http\Controllers\Admin\TagsController', 'edit'])->name('edit');
        
    });
    
    Route::name('author.')->prefix('/authors/')->group(function(){
        Route::get('/index', ['App\Http\Controllers\Admin\AuthorsController', 'index'])->name('index');
        Route::post('/ajax-authors-datatable', ['App\Http\Controllers\Admin\AuthorsController', 'datatable'])->name('datatable');
        Route::get('/add-author', ['App\Http\Controllers\Admin\AuthorsController', 'addAuthor'])->name('add_author');
        Route::post('/store-author', ['App\Http\Controllers\Admin\AuthorsController', 'store'])->name('store_author');
        Route::post('/change-ban-status', ['App\Http\Controllers\Admin\AuthorsController', 'changeBanStatus'])->name('change_ban_status');
        
    });
    
});

Auth::routes();

