<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Cloudinary;
//use Cloudinary\Uploader;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation rules for the image upload
        ]);
    
        $categoryData = $request->except('image'); // Exclude the 'image' field from the data
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images'); // Store the image in the public/images directory
            $categoryData['image'] = $imagePath; // Save the image URL in the 'image' column of the database
        }
    
        Category::create($categoryData);
    
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }
    


    public function edit($id)
{
    $category = Category::findOrFail($id);
    return view('categories.edit', compact('category'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|string',
    ]);

    $category = Category::findOrFail($id);

    $category->update([
        'name' => $request->name,
        'description' => $request->description,
        'image' => $request->image,
    ]);

    return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
}

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

}
