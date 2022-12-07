<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view ('category',['categories'=>$categories]);
    }
    
    public function add()
    {
        return view ('category-add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories|max:100',
        ]);
        // $category = Category::create($request->all());
        DB::insert('INSERT INTO categories(name) VALUES (:name)',
        [
            'name' => $request->name,
        ]);
        return redirect ('categories')-> with ('status','Category added successfully!'); 
    }

    public function edit($name)
    {
        $category = DB::table('categories')->where('name',$name)->first();
        return view ('category-edit',['category'=>$category]);
    }

    public function update(Request $request, $name)
    {
        $category = DB::table('categories')->where('name',$name)->update([
            'name'=>$request['name'],
        ]);
        return redirect ('categories')-> with ('status','Category added successfully!'); 
    }

    public function delete($name)
    {
        $category = DB::table('categories')->where('name', $name)->first();
        return view('category-delete',['category'=>$category]);
    }

    public function destroy($name)
    {
        $category = DB::table('categories')->where('name', $name)->update(['deleted_at' => Carbon::now()]);
       return redirect ('categories')-> with ('status','Category deleted successfully!'); 
    }

    public function deletedCategory()
    {
        $deletedCategories = DB::table('categories')->whereNotNull('deleted_at')->get();
        return view ('category-deleted-list',['deletedCategories'=>$deletedCategories]); 
    }

    public function restore($name)
    {
        $category = DB::update('UPDATE categories SET deleted_at = NULL WHERE name = :name', ['name' => $name]);
       return redirect ('categories')-> with ('status','Category restored successfully!'); 
    }
    // public function deletedFix($name)
    // {

    //     $deletedCategories = DB::delete('DELETE FROM categories WHERE name = :name', ['name' => $name]);
    //     // $deletedCategories = DB::table('categories')->whereNotNull('deleted_at')->get();
    //     return view ('category-deleted-list'); 
    // }
}
