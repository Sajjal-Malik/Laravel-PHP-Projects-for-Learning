<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index(Request $request){

        $categories = Category::select(['id', 'name', 'type']);
        
        if($request->ajax()){
            return DataTables::of($categories)
            ->addColumn('action', function($row){
                return '<a href="" class="btn btn btn-info editButton" data-id="'. $row->id . '">Edit</a>
                        <a href="" class="btn btn btn-danger delButton" data-id="'. $row->id . '">Delete</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('categories.create');
    }

    public function create() {

        return view('categories.create');
    }

    public function store(Request $request){
        
        $request->validate([
            'name' => 'required|min:3|max:50',
            'type' => 'required',
        ]);

        Category::create([
            'name' => $request->name,
            'type' => $request->type
        ]);

        return response()->json([
            'success' => 'Category saved successfully'
        ], 201);
    }

    public function edit($id){

        $category = Category::find($id);
        if(!$category){
            abort(404, 'Category not found');
        }
        return $category;
    }
}
