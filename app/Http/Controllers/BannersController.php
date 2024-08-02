<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use DataTables,Auth;
use Illuminate\Support\Facades\File;

class BannersController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
  }

   public function index() {
      return view('banners.index');
   }
   public function getBannerList(Request $request)
   {
      $data  = Banner::get();
      return Datatables::of($data)
      ->addColumn('action', function($data){
         return '<div class="table-actions">
                     <a href="'.url('banners/view/'.$data->banner_id).'" ><i class="ik ik-eye f-20 mr-15 text-green d-none"></i></a>
                     <a href="'.url('banners/'.$data->banner_id).'" ><i class="ik ik-edit-2 f-20 mr-15 text-green"></i></a>
                     <a href="#" class="delete-item" data-id="'.$data->banner_id.'"><i class="ik ik-trash-2 f-20 text-red"></i></a>
                  </div>';
      })->make(true);
   }
   public function create() {
      return view('banners.create');
   }
   public function store(Request $request) 
   {
         // Validate the request
         $request->validate([
            'title' => 'required',
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' // max 2MB
         ]);
         
         // Get the file from the request
         $image = $request->file('banner');
         
         // Generate a file name
         $bannerName = time().'.'.$image->extension();
         
         // Move the image to the storage directory
         $image->move(public_path('banner'), $bannerName);
         
         // Save image path in the database
         $imagePath = '/banner/' . $bannerName;
         
         try
         {
            $bannerData = Banner::create([
                  'title' => $request->title,
                  'banner' => $bannerName,
                  'description' => $request->description,
                  'status' => $request->status,
            ]);
            if($bannerData){ 
               return redirect('banners')->with('success', 'Banner created successfully.');
            }else{
               return redirect('banners')->with('error', 'Failed to create banner! Try again.');
            }
         }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
         }
   }
   public function show($id) {
      echo 'show';
   }
   public function edit($id) {
      $banner = Banner::findOrFail($id);
      return view('banners.edit', compact('banner'));
   }
   public function update(Request $request) {
      $id = $request->banner_di;
      $request->validate([
         'title' => 'required',
         'banner_new' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // max 2MB
     ]);
     try{
      $banner = Banner::find($request->banner_id);
      if ($banner) {
         
         $bannerName = $banner->banner;
         // Handle image upload if new image provided
         if ($request->hasFile('banner_new')) {
            
            
            $image = $request->file('banner_new');
         
            // Generate a file name
            $bannerName = time().'.'.$image->extension();
            
            // Move the image to the storage directory
            $image->move(public_path('banner'), $bannerName);
            
            $file_path = public_path('banner/').$banner->banner;
            //You can also check existance of the file in storage.
            if(File::exists($file_path)) {
               unlink($file_path); //delete from storage
            }
   
         }
         
         $banner->update([
            'title' => $request->title,
            'banner' => $bannerName,
            'description' => $request->description,
            'status' => $request->status,
            ]);
         return redirect()->back()->with('success', 'Banner updated successfully.');
      } else {
      return redirect()->back()->with('error', 'Banner updated faild!');
      }
     }catch (\Exception $e) {
         $bug = $e->getMessage();
         return redirect()->back()->with('error', $bug);
     }
   }
   public function delete($id) {
      $BannerData = Banner::where(['banner_id' => $id])->first();
        if($BannerData){
            $bannerName = $BannerData->banner;
            $BannerData->delete();
            $file_path = public_path('banner/').$bannerName;
            //You can also check existance of the file in storage.
            if(File::exists($file_path)) {
               unlink($file_path); //delete from storage
            }
            return response()->json(['success' => true]);
         }else{
           return response()->json(['success' => false], 404);
         }
    }
}
