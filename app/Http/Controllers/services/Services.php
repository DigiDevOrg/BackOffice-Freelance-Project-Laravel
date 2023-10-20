<?php

namespace App\Http\Controllers\services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;

class Services  extends Controller
{
  public function index()
  {
    
    $services = Service::all();
    return view('Services.services-basic', compact('services'));
  }
  //get service by idCategorie 
  public function getServiceByIdCategorie($idCategorie)
  {
    $services = Service::where('category_id', $idCategorie)->get();
    return view('Services.services-basic', compact('services'));
  }

  //get service by id
  public function getServiceById($id)
  {
    $service = Service::find($id);
    return view('Services.service-details', compact('service'));
  }
  
  //get service by id user
  public function getServiceByIdUser($id)
  {
    $services = Service::where('user_id', $id)->get();
    // get user  name from services
    foreach ($services as $service) {
      $service->user_name = $service->user->name;
    }
    return view('Services.services-basic', compact('services'));
  }
  

  public function edit($id)
  {
      // Retrieve the service by its ID
      $service = Service::find($id);
      $categories = Category::all();
    
      if (!$service) {
          // Handle the case where the service does not exist
          return redirect()->back()->with('error', 'Service not found');
      }
  
      return view('Services.edit-service', compact('service','categories'));
  }

  public function update(Request $request, $id)
{
  
    // $request->validate([
    //     'title' => 'required|string|max:255',
    //     'description' => 'required|string',
    //     'price' => 'required|numeric',
    //     'delivery_time' => 'required|string',
    //     'Category' => 'required|string',
    //     'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
    // ]);
    
    $service = Service::findOrFail($id);
   
    if (!$service) {
        dd("here");
        return redirect()->back()->with('error', 'Service not found');
    }

    $service->title = $request->input('title');
    $service->description = $request->input('description');
    $service->price = $request->input('price');
    $service->delivery_time = $request->input('delivery_time');
    $service->Category = $request->input('category');    
   
    if ($request->hasFile('image')) {
      $originalName = $request->file('image')->getClientOriginalName();
      $imagePath = $request->file('image')->storeAs('public/assets/img/service', $originalName);
      
      if ($service->image) {
        
          Storage::disk('public')->delete($service->image);
      }
      
      $service->image = $originalName;
     
  }
    $service->update();
    
    $categories = Category::all();

    return redirect()->route('edit-service', ['id' => $id])
        ->with('success', 'Service details updated successfully');
    

}

}
