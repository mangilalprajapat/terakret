<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\UserBank;
use App\Models\Withdrawal;
use App\Models\Wallets;
use DataTables,Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
  }

   public function index() {
      // return view('pages.view');
      return view('withdrawal.index');
   }
   public function getWithdrawalList(Request $request)
   {
      $data  = Withdrawal::with('customer','userbank')->orderBy('created_at', 'desc')->get();
      return Datatables::of($data)
      ->addColumn('action', function($data){
         return '<div class="table-actions">
                     <a href="'.url('withdrawal/view/'.$data->withdrawal_id).'" ><i class="ik ik-eye f-16 mr-15 text-green"></i></a>
                     <a href="'.url('withdrawal/'.$data->withdrawal_id).'" ><i class="ik ik-edit-2 f-16 mr-15 text-green d-none"></i></a>
                     <a href="'.url('withdrawal/delete/'.$data->withdrawal_id).'"  ><i class="ik ik-trash-2 f-16 text-red"></i></a>
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
      $withdrawal = Withdrawal::with('customer','userbank')->find($id);
      // return view('pages.form-addon');
      return view('withdrawal.view',compact('withdrawal'));
   }
   public function edit($id) {
      
      echo 'edit';
   }
   public function update(Request $request) {
      echo 'Update';
   }
   public function StatusUpdate(Request $request) {
      
      DB::beginTransaction();
      try {     
         // Fetch the existing model instance
         $WithdrawalData = Withdrawal::where(['withdrawal_id' => $request->input('withdrawal_id'), 'is_deleted' => false])->first();
         if(empty($WithdrawalData)){
            return response()->json(['errors' => 'Order not found!', 'status' => 400]);
         }
         // Get the previous status value
         $previousStatus = $WithdrawalData->status;
         $validator = Validator::make($request->all(), [
         'status' => [
            'required',
            'string',
            'in:P,S,F,R,C',
            function ($attribute, $value, $fail) use ($previousStatus) {
                  if ($value === $previousStatus) {
                     $fail('The status has not changed.');
                  }
            },
         ],
         'transactionid' => 'nullable|required_if:status,S|unique:withdrawal,transaction_id',
         'description' => [
            'nullable',
            Rule::requiredIf(function () use ($request) {
                  return in_array($request->input('status'), ['C', 'R', 'F']);
            }),
            ],
         ], [
            'transactionid.required' => 'Please enter transaction id !!',
            'transactionid.required_if' => 'Please enter transaction id !!',
            'status.required' => 'Please select status !!',
            'description.required' => 'Please enter description !!',
         ]);
         
         if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
         }
         $WithdrawalData->update([
            'transaction_id' => $request->transactionid,
            'status' => $request->status,
            'description' => $request->description,
         ]);
         if($request->status != 'S'){
            Customer::where('customer_id', $request->input('customer_id'))->increment('coupon_points', $request->redeem_points);
         }else{
            Customer::where('customer_id', $request->input('customer_id'))->increment('wallet_amount', $request->reddeem_amounts);
            Wallets::create([
               'customer_id'    => $request->customer_id,
               'withdrawal_id'  => $request->withdrawal_id,
               'amount'         => $request->reddeem_amounts,
           ]);
         }
         DB::commit();
         return response()->json(['message' => 'Widthdrawal request update successfully!','status' => 200]);
         
      } catch (\Throwable $th) {
         DB::rollback();
         return response()->json(['errors' => 'Something went wrong, Please try again!'.$th,400]);
      }
   }
   
   public function delete($id) {
      $WithdrawalData = Withdrawal::where(['withdrawal_id' => $id])->first();
        if($WithdrawalData){
            $WithdrawalData->update(['is_deleted' => 1]);
            
            return redirect('withdrawal')->with('success', 'Withdrawal request removed!');
        }else{
            return redirect('withdrawal')->with('error', 'Withdrawal not found');
        }
    }
}
