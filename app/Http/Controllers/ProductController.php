<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductsCateogry;
use App\Models\Products;
use DataTables,Auth;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
  }

   public function index() {
      return view('products.index');
   }
   public function getProductList(Request $request)
   {
      $data  = Products::with('productcategory')->where(['is_deleted' =>0])->get();
      return Datatables::of($data)
      ->addColumn('action', function($data){
         return '<div class="table-actions">
                     <a href="'.url('product/view/'.$data->product_id).'" ><i class="ik ik-eye f-20 mr-15 text-green d-none"></i></a>
                     <a href="'.url('product/'.$data->product_id).'" ><i class="ik ik-edit-2 f-20 mr-15 text-green"></i></a>
                     <a href="#" class="delete-item" data-id="'.$data->product_id.'"><i class="ik ik-trash-2 f-20 text-red"></i></a>
                  </div>';
      })->make(true);
   }
   public function create() {
      $product_cateogry = ProductsCateogry::pluck('name','category_id');
      return view('products.create',compact('product_cateogry'));
   }
   public function store(Request $request) 
   {
         // Validate the request
         $request->validate([
            'name' => 'required|unique:products',
            'category_id' => 'required',
            'price' => 'required',
            'size' => 'required',
            'product_code' => 'required|unique:products',
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' // max 2MB
         ]);
         
         // Get the file from the request
         $image = $request->file('product_image');
         
         // Generate a file name
         $productImage = time().'.'.$image->extension();
         
         // Move the image to the storage directory
         $image->move(public_path('products'), $productImage);
         
         try
         {
            $productData = Products::create([
                  'name' => $request->name,
                  'category_id' => $request->category_id,
                  'product_image' => $productImage,
                  'sale_price' => $request->sale_price,
                  'price' => $request->price,
                  'size' => $request->size,
                  'product_code' => $request->product_code,
                  'description' => $request->description,
                  'status' => $request->status,
            ]);
            if($productData){ 
               return redirect('product')->with('success', 'Product created successfully.');
            }else{
               return redirect('product')->with('error', 'Failed to create product! Try again.');
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
      
      $product_cateogry = ProductsCateogry::pluck('name','category_id');
      $products = Products::findOrFail($id);
      return view('products.edit', compact('products','product_cateogry'));
   }
   public function update(Request $request) {
      $id = $request->product_id;
      $request->validate([
         'name' => 'required|unique:products,product_id,'.$id.',product_id',
         'category_id' => 'required',
         'price' => 'required',
         'size' => 'required',
         'product_code' => 'required|unique:products,product_id,'.$id.',product_id',
         'product_image_new' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
     ]);
     try{
      $products = Products::find($request->product_id);
      if ($products) {
         
         $productimageName = $products->product_image;
         // Handle image upload if new image provided
         if ($request->hasFile('product_image_new')) {
            
            $image = $request->file('product_image_new');
            // Generate a file name
            $productimageName = time().'.'.$image->extension();
            
            // Move the image to the storage directory
            $image->move(public_path('products'), $productimageName);
            
            $file_path = public_path('products/').$products->product_image;
            //You can also check existance of the file in storage.
            if(File::exists($file_path)) {
               unlink($file_path); //delete from storage
            }
         }
         $products->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'product_image' => $productimageName,
            'sale_price' => $request->sale_price,
            'price' => $request->price,
            'size' => $request->size,
            'product_code' => $request->product_code,
            'description' => $request->description,
            'status' => $request->status,
            ]);
         return redirect()->back()->with('success', 'Product updated successfully.');
      } else {
      return redirect()->back()->with('error', 'Product updated faild!');
      }
     }catch (\Exception $e) {
         $bug = $e->getMessage();
         return redirect()->back()->with('error', $bug);
     }
   }
   public function delete($id) {
      $ProductData = Products::where(['product_id' => $id])->first();
        if($ProductData){
            $productImageName = $ProductData->product_image;
            $ProductData->delete();
            $file_path = public_path('products/').$productImageName;
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
