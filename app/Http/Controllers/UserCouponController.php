<?php

namespace App\Http\Controllers;
use App\Models\Coupon;
use App\Models\UserCoupon;
use App\Models\Customer;
use Illuminate\Http\Request;
use DataTables,Auth;

class UserCouponController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

   public function index() {
      // return view('pages.ui.badges');
      return view('user_coupon.index');
   }
   public function getUserCouponList(Request $request)
   {
      $data  = UserCoupon::with('customer')->where(['is_deleted'=> 0])->get();
      return Datatables::of($data)
      ->addColumn('status', function($data){
         $statusValue = $data->status;
         $status = '';
         if($statusValue){
             if($statusValue == "A"){
               $status = "Active";
             }else{
               $status = "Inactive";
             }
         }

         return $status;
     })
      ->addColumn('action', function($data){
         return '<div class="table-actions">
                     <a href="'.url('user_coupon/view/'.$data->user_coupon_id).'" ><i class="ik ik-eye f-16 mr-15 text-green d-none"></i></a>
                     <a href="'.url('user_coupon/'.$data->user_coupon_id).'" ><i class="ik ik-edit-2 f-16 mr-15 text-green d-none"></i></a>
                     <a href="'.url('user_coupon/delete/'.$data->user_coupon_id).'"  ><i class="ik ik-trash-2 f-16 text-red"></i></a>
                  </div>';
      })->make(true);
   }
   public function create() {
      return view('pages.widget-statistic');
   }
   public function store(Request $request) {
      echo 'store';
   }
   public function show($id) {
      echo 'show';
   }
   public function edit($id) {
      echo 'edit';
   }
   public function update(Request $request, $id) {
      echo 'update';
   }
   public function delete($id) {
      $UserCouponData = UserCoupon::where(['user_coupon_id' => $id, 'is_deleted' => false])->first();
        if($UserCouponData){
            $UserCouponData->update(['is_deleted' => 1]);
            return redirect('user_coupon')->with('success', 'User Coupon deleted successfully.');
        }else{
            return redirect('user_coupon')->with('error', 'User Coupon not found');
        }
   }
}
