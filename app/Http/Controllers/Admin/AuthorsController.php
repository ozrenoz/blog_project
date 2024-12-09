<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;
use Yajra\DataTables\Facades\DataTables;

class AuthorsController extends Controller
{
    public function index() {
    return view('admin.authors.index');
    }
    
    /*metoda za izradu tabele autora u admin delu*/
    public function datatable() {
        $query = Author::query();

        $datatable = DataTables::of($query);
        $datatable->addColumn('photo', function($row) {
            return '<img src="' . $row->getImageUrl() . '" style="height: 100px">';
        })->editColumn('created_at', function($row) {
            return date_format($row->created_at, 'd.m.Y H:i:s');
        })->editColumn('ban', function($row) {
            return $row->ban ? 'ban' : 'active';
        })->addColumn('actions', function($row) {
            return view('admin.authors.partials.actions', ['author' => $row]);
        })->rawColumns(['photo', 'actions']);

        return $datatable->toJson();
    }
    
    /*metoda nas vodi na blejd za dodavanje novog autora*/
    public function addAuthor() {
        return view('admin.authors.add_author');
    }
    
    /*metoda za cuvanje novog autora*/
    public function store(Request $request){
    $data = $request->validate([
        'name' => ['required', 'string', 'min:3', 'max:50'],
        'email' => ['required', 'email'],
        'phone' => ['required', 'string', 'min:10', 'max:20'],
        'photo' => ['nullable', 'file', 'max:5000', 'mimes:jpg,png,jpeg']
    ]);

    $author = new Author();
    $author->fill($data);
    $author->save();

    // Cuvanje fotografije ako je upload-ovana
    if ($request->hasFile('photo')) {
        $photo = $request->file('photo');
        $photo_name = $author->id . '_' . $photo->getClientOriginalName();
        $photo->move(public_path('/storage/photos'), $photo_name);
        $author->photo = $photo_name;
        $author->save();
    }

    session()->put('system_message', 'Author successfully added!');
    return redirect()->route('admin.author.index');
    }
    
    /*metoda za promenu ban statusa autora*/
    public function changeBanStatus() {
        $data = request()->validate([
            'id' => ['required', 'numeric', 'exists:authors,id']
        ]);

        $author = Author::findOrFail($data['id']);
        $author->ban = !$author->ban;
        $author->save();

        return response()->json(['status' => 'ok']);
    }

    /*metoda za cuvanje fotografije*/
    private function savePhoto($photo, $author) {
        $photoName = $author->id . '_' . $photo->getClientOriginalName();
        $photo->move(public_path('/storage/photos'), $photoName);

        $author->photo = $photoName;
        $author->save();
    }
}
