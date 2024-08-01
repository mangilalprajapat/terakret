<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Coupon;
use DataTables,Auth;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
   public function index() {
      $coupons = Coupon::all();
      return view('coupons.index', compact('coupons'));
   }
   public function getCouponList(Request $request)
   {
      $data  = Coupon::where(['is_deleted'=> 0])->get();
      return Datatables::of($data)
      ->addColumn('action', function($data){
         return '<div class="table-actions">
                     <a href="'.url('coupon/view/'.$data->coupon_id).'" ><i class="ik ik-eye f-16 mr-15 text-green d-none"></i></a>
                     <a href="'.url('coupon/'.$data->coupon_id).'" ><i class="ik ik-edit-2 f-16 mr-15 text-green"></i></a>
                     <a href="'.url('coupon/delete/'.$data->coupon_id).'"  ><i class="ik ik-trash-2 f-16 text-red"></i></a>
                  </div>';
      })->make(true);
   }
   public function create() {
      return view('coupons.create');
   }
   public function store(Request $request) 
   {
      $request->validate([
         'code' => 'required|unique:coupon',
         'points' => 'required|numeric|min:1|max:1000',
         'maximum_usage' => 'required|numeric|min:1',
         'user_limit' => 'required|numeric|min:1',
         'start_at' => 'required|date_format:Y-m-d|before_or_equal:expired_at',
         'expired_at' => 'required|date_format:Y-m-d|after_or_equal:start_at',
         'status' => 'required',
     ]);

      try
      {
         $couponData = Coupon::create([
               'code' => $request->code,
               'points' => $request->points,
               'maximum_usage' => $request->maximum_usage,
               'user_limit' => $request->user_limit,
               'start_at' => $request->start_at,
               'expired_at' => $request->expired_at,
               'description' => $request->description,
               'status' => $request->status,
         ]);
         if($couponData){ 
            return redirect('coupon')->with('success', 'Coupon created successfully.');
         }else{
            return redirect('coupon')->with('error', 'Failed to create coupon! Try again.');
         }
      }catch (\Exception $e) {
         $bug = $e->getMessage();
         return redirect()->back()->with('error', $bug);
      }
   }
   public function show($id) {
      // return view('pages.ui.badges');
   }
   public function edit($id) {
      $coupon = Coupon::findOrFail($id);
      return view('coupons.edit', compact('coupon'));
   }
   public function update(Request $request) {
      $id = $request->coupon_id;
      $request->validate([
         'code' => 'required|unique:coupon,coupon_id,'.$id.',coupon_id',
         'points' => 'required|numeric|min:1|max:1000',
         'maximum_usage' => 'required|numeric|min:1',
         'user_limit' => 'required|numeric|min:1',
         'start_at' => 'required|date_format:Y-m-d|before_or_equal:expired_at',
         'expired_at' => 'required|date_format:Y-m-d|after_or_equal:start_at',
         'status' => 'required',
     ]);
     try{
      $customer = Coupon::find($request->coupon_id);
      if ($customer) {
         $customer->update([
            'code' => $request->code,
            'points'    => $request->points,
            'maximum_usage' => $request->maximum_usage,
            'user_limit' => $request->user_limit,
            'start_at'    => $request->start_at,
            'expired_at'    => $request->expired_at,
            'description'    => $request->description,
            'status'    => $request->status,
            ]);
         return redirect()->back()->with('success', 'Coupon updated successfully.');
      } else {
      return redirect()->back()->with('error', 'Coupon updated faild!');
      }
     }catch (\Exception $e) {
         $bug = $e->getMessage();
         // return redirect()->back()->with('error', $bug);
         return redirect()->back()->with('error', "Somthing went wrong, Please try again");
     }
   }
   public function delete($id) {
      $CouponData = Coupon::where(['coupon_id' => $id, 'is_deleted' => false])->first();
        if($CouponData){
            $CouponData->update(['is_deleted' => 1]);
            return redirect('coupon')->with('success', 'Coupon deleted successfully.');
        }else{
            return redirect('coupon')->with('error', 'Coupon not found');
        }
    }
}
