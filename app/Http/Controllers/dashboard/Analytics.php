<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Analytics extends Controller
{
    public function index()
    {
        $services1 = Service::all();
        $id = Auth::user()->id;

        $categories = Category::all();
        $services = Service::where('user_id', $id)->get();

        $name = Auth::user()->name;
        if (!isset($name)) {
            dd('gee');

            return view('Services.services-basic', compact('services'));
        } else {
            return view('content.dashboard.dashboards-analytics', compact('services', 'categories', 'name'));
        }
    }

    public function create($id = 15)
    {
        $categories = Category::all();

        return view('content.dashboard.dashboards-analytics', compact('categories'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'delivery_time' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);
        $service = new Service([
          'title' => $validatedData['title'],
          'description' => $validatedData['description'],
          'price' => $validatedData['price'],
          'delivery_time' => $validatedData['delivery_time'],
          'Category' => $validatedData['category_id'],
      ]);
        if ($request->hasFile('image')) {
            $originalName = $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('public/assets/img/service', $originalName);

            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $service->image = $originalName;
        }
        $service->user()->associate($user);
        $service->save();
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachmentFile) {
                $attachment = new Attachment();
                $attachment->service_id = $service->id;
                $attachment->filename = $attachmentFile->getClientOriginalName();
                $attachment->filesize = $attachmentFile->getSize();
                $attachment->filetype = $attachmentFile->getClientMimeType();
                $attachment->uploaddate = now();
                $attachmentFile->storeAs('public/files', $attachment->filename);

                $attachment->save();
            }

            return redirect()->route('dashboard-analytics');
        }
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('dashboard-analytics');
    }
}
