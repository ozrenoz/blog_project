<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Cache;

class TagsController extends Controller
{

public function index() {
    return view('admin.tags.index');
}
    
/*metoda za kreiranje tags tabele u admin delu*/
    public function datatable(){
        $query = Tag::query();
        $datatable = DataTables::of($query);
        
        $datatable->editColumn('created_at',function($row){
            return date_format($row->created_at, 'd.m.Y H:i:s');
        })->addColumn('actions',function($row){
            return view('admin.tags.partials.actions',[
                "tag" => $row
            ]);
        })->rawColumns(['actions']);
        
        return $datatable->toJson();
    }
    
    /*metoda za cuvanje novog taga*/
    public function store(){
        
        $data = request()->validate([
            'name' => ['required','string','min:1','max:50','unique:tags,name']
        ]);
        $data['created_at'] = now();
        
        $new_tag = new Tag();
        $new_tag->fill($data);
        $new_tag->save();
        
        //ciscnjenje tags cache
        Cache::forget('all_tags');
        
        return response()->json(['status' => 'ok']);
    }
    
    /*metoda za brisanje taga*/
    public function delete(){
        $data = request()->validate([
            'id' => ['required','numeric','exists:tags,id']
        ]);
        
        $tag_for_delete = Tag::findOrFail($data['id']);
        $tag_for_delete->delete();
        
        //ciscnjenje tags cache
        Cache::forget('all_tags');
        
        return response()->json(['status' => 'ok']);
    }
    
    /*metoda za editovanje/izmenu taga*/
    public function edit(){
        $data = request()->validate([
            'id' => ['required','numeric','exists:tags,id'],
            'name' => ['required','string','min:1','max:50','unique:tags,name']
        ]);
        
        $tag_for_edit = Tag::findOrFail($data['id']);
        $tag_for_edit->name = $data['name'];
        $tag_for_edit->save();
        
        //ciscnjenje tags cache
        Cache::forget('all_tags');
        
        return response()->json(['status' => 'ok']);
    }    
    
}
