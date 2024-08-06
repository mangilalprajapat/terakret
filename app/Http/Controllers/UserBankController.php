<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\UserBank;
use DataTables,Auth;
use Illuminate\Support\Facades\File;

class UserBankController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
  }

   public function index() {
      return view('user_bank.index');
   }
   public function getUserBankList(Request $request)
   {
      $data  = UserBank::with('customer')->where(['is_deleted' => false])->orderBy('created_at','desc')->get();
      return Datatables::of($data)
      ->addColumn('action', function($data){
         return '<div class="table-actions">
                     <a href="'.url('user_bank/view/'.$data->bank_id).'" ><i class="ik ik-eye f-20 mr-15 text-green d-none"></i></a>
                     <a href="'.url('user_bank/'.$data->bank_id).'" ><i class="ik ik-edit-2 f-20 mr-15 text-green d-none"></i></a>
                     <a href="#" class="delete-item" data-id="'.$data->bank_id.'"><i class="ik ik-trash-2 f-20 text-red"></i></a>
                  </div>';
      })->make(true);
   }
   public function create() {
      echo 'create';
   }
   public function store(Request $request) 
   {
      echo 'store';
   }
   public function show($id) {
      echo 'show';
   }
   public function edit($id) {
      
      echo 'edit';
   }
   public function update(Request $request) {
      echo 'Update';
   }
   public function delete($id) {
      $UserBankData = UserBank::where(['bank_id' => $id])->first();
        if($UserBankData){
            $userBankImageName = $UserBankData->product_image;
            $UserBankData->update(['is_deleted' => 1]);
            $file_path = public_path('user_bank/').$userBankImageName;
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
