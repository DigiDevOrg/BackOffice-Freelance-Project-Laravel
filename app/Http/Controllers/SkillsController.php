<?php

namespace App\Http\Controllers;

use App\Models\Skills;
use Illuminate\Http\Request;
use App\Models\Category;

class SkillsController extends Controller
{
    public function index()
    {
        $skills = Skills::all();
        return view('skills.index', compact('skills'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('skills.create', compact('categories'));
       
    }

    public function store(Request $request)
    {
     
        $request->validate([
            'skillName' => 'required|string|max:255',
            'description' => 'required',
            'category_id' => 'required',
        ]);
    
        $skill = Skills::create($request->all());
    
        return redirect()->route('categories.edit', ['category' => $request->category_id])
            ->withSuccess(__('Skill created successfully!'));
    }
    

    public function show(Skills $skill)
    {
        return view('skills.show', compact('skill'));
    }

    public function edit(Skills $skill)
    {
        return view('skills.edit', compact('skill'));
    }

    public function update(Request $request, Skills $skill)
    {
        $request->validate([
            'skillName' => 'required|string|max:255',
            'description' => 'required',
            'category_id' => 'required',
        ]);

        $skill->update($request->all());

        return redirect()->route('skills.index')->with('success', 'Skill updated successfully');
    }

    public function destroy(Skills $skill)
    {
        $skill->delete();

        return redirect()->route('skills.index')->with('success', 'Skill deleted successfully');
    }

    public function getSkills($categoryId)
{
    
    $category = Category::find($categoryId);


    $skills = $category->skills;

    return response()->json($skills);
}
}
