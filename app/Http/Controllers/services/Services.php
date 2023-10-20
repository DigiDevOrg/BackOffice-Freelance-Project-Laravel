<?php

namespace App\Http\Controllers\services;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Services extends Controller
{
    public function index()
    {
        $services = Service::all();

        return view('Services.services-basic', compact('services'));
    }

    // get service by idCategorie
    public function getServiceByIdCategorie($idCategorie)
    {
        $services = Service::where('category_id', $idCategorie)->get();

        return view('Services.services-basic', compact('services'));
    }

    // get service by id
    public function getServiceById($id)
    {
        $service = Service::find($id);

        return view('Services.service-details', compact('service'));
    }

    // get service by id user
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

        return view('Services.edit-service', compact('service', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        if (!$service) {
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
        }
        $service->update();

        $categories = Category::all();

        return redirect()->route('edit-service', ['id' => $id])
            ->with('success', 'Service details updated successfully');
    }

    public function deleteA($filename)
    {
         $attachment = Attachment::findOrFail($filename);
        // if (!$attachment) {
        //     return redirect()->back()->with('error', 'Attachment not found');
        // }
            dd($attachment);
        // // Delete the attachment file from storage
        // dd(Storage::delete('storage/public/files/'.$attachment->filename));

        // // Delete the attachment record from the database
        // $attachment->delete();

        return redirect()->back()->with('success', 'Attachment deleted successfully');
    }
}
