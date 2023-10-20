<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
class Analytics extends Controller
{
  public function index()
  {
    $services1 = Service::all();
    $id = Auth::user()->id ;
    
    $categories = Category::all();
    $services = Service::where('user_id', $id)->get();
   
    $name = Auth::user()->name ;
    if(!isset($name)){
      dd("gee");
      return view('Services.services-basic', compact('services'));
    }else{
      return view('content.dashboard.dashboards-analytics', compact('services','categories','name'));

    }
    
  }
public function create($id = 15) {
    
    $categories = Category::all();
    return view('content.dashboard.dashboards-analytics', compact('categories'));
}
  public function store(Request $request)
    {
        // Validate the incoming data
        $user = Auth::user();

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'delivery_time' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            

        ]);

        // Set the default user ID to 15
        $service = new Service([
          'title' => $validatedData['title'],
          'description' => $validatedData['description'],
          'price' => $validatedData['price'],
          'delivery_time' => $validatedData['delivery_time'],
          'Category' => $validatedData['category_id'],


      ]);
  
        $service->user()->associate($user);
        
        // Create a new service with the validated data
        $service->save();

        // Redirect back with a success message or to a different page
        return redirect()->route('dashboard-analytics');
      }
          public function destroy($id)
          {
              $service = Service::findOrFail($id);
              $service->delete();
              
              return redirect()->route('dashboard-analytics', ['id' => 15]);
          }
      public function edit($id)
      {
          $services = Service::where('user_id', 15)->get();
          
          $service = Service::findOrFail($id);
          $categories = Categorie::all();

          return view('content.dashboard.dashboards-analytics', compact('service', 'categories','services'));
      }

public function update(Request $request, $id)
{
    $validatedData = $request->validate([
      'title' => 'required|string|max:255',
      'description' => 'required|string',
      'price' => 'required|numeric',
      'delivery_time' => 'required|integer',
      'category_id' => 'required|exists:categories,id',
      

  ]);

    $service = Service::findOrFail($id);
    $service->update($validatedData);

    return redirect()->route('dashboard-analytics', ['id' => 15]);
}
}
