<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerType;
use Spatie\Permission\Models\Role;
use DataTables,Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class CustomerController extends Controller
{
   public function __construct(){
        $this->middleware('auth');
    }

   public function index() {
      $customer = Customer::get();
      return view('customer.index');
   }
   public function getCustomerList(Request $request)
   {
      $data  = Customer::with('customertype')->where('is_deleted',0)->get();
      return Datatables::of($data)
      ->addColumn('action', function($data){
         return '<div class="table-actions">
                     <a href="'.url('customer/view/'.$data->customer_id).'" ><i class="ik ik-eye f-16 mr-15 text-green d-none"></i></a>
                     <a href="'.url('customer/'.$data->customer_id).'" ><i class="ik ik-edit-2 f-16 mr-15 text-green"></i></a>
                     <a href="'.url('customer/delete/'.$data->customer_id).'"  ><i class="ik ik-trash-2 f-16 text-red"></i></a>
                  </div>';
      })->make(true);
   }
   public function create() {
      $statusOptions = [
         'Active' => 'Active',
         'Inactive' => 'Inactive',
         // 'Rejected' => 'Rejected',
     ];
      $customer_type = CustomerType::pluck('customer_type','customer_type_id');
      return view('customer.create', compact('customer_type','statusOptions'));
   }
   public function store(Request $request) {
       // create customer 
       $validator = Validator::make($request->all(), [
         'name'   => 'required | string ',
         'email'  => 'required|unique:customers,email,NULL,id',
         'phone' => 'required|unique:customers|digits:10',
         'customer_type'=> 'required',
         'status' => 'required',
     ]);
     
     if($validator->fails()) {
         return redirect()->back()->withInput()->with('error', $validator->messages()->first());
     }
     try
     {
         // store customer information
         $customerData = Customer::create([
                     'username' => $request->name,
                     'email'    => $request->email,
                     'phone'    => $request->phone,
                     'customer_type'    => $request->customer_type,
                     'status'    => $request->status,
                     'password' => Hash::make($request->phone),
                 ]);
         if($customerData){ 
             return redirect('customer')->with('success', 'New customer created!');
         }else{
             return redirect('customer')->with('error', 'Failed to create new customer! Try again.');
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
      try
      {
         $customer  = Customer::with('customertype')->find($id);

            if($customer){
               
               $selectedCustomerType = $customer->customer_type;

               $customer_type = CustomerType::pluck('customer_type','customer_type_id');
               return view('customer.edit', compact('customer','customer_type','selectedCustomerType'));
            }else{
               return redirect('404');
            }         
      }catch (\Exception $e) {
          $bug = $e->getMessage();
          return redirect()->back()->with('error', $bug);
      }
   }
   public function update(Request $request) {
      
        // update user info
        $validator = Validator::make($request->all(), [
         'customer_id'       => 'required',
         'name'     => 'required | string ',
         'email'    => 'required | email',
         'phone'     => 'required'
     ]);

      
      if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
      }

      try{
         $customer = Customer::find($request->customer_id);
         if ($customer) {
            $customer->update([
               'username' => $request->name,
               'email'    => $request->email,
               'phone'    => $request->phone,
               'customer_type'    => $request->customer_type,
               'status'    => $request->status,
               ]);
            return redirect()->back()->with('success', 'Customer information updated succesfully!');
         } else {
         return redirect()->back()->with('success', 'Customer information updated faild!');
         }

      }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

      }
   }
   public function delete($id) {
     $CustomerData = Customer::where(['customer_id' => $id, 'is_deleted' => false])->first();
       if($CustomerData){
           $CustomerData->update(['is_deleted' => 1]);
           return redirect('customer')->with('success', 'Customer removed!');
       }else{
           return redirect('customer')->with('error', 'Customer not found');
       }
   }
}
