<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Countries;
use App\Models\States;
use App\Models\Cities;
use App\Models\CustomerType;
use Spatie\Permission\Models\Role;
use DataTables,Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Carbon\Carbon;


class CustomerController extends Controller
{
   public function __construct(){
        $this->middleware('auth');
    }

   public function index() {
      $customer = Customer::get();
      // return view('pages.ui.icons');
      return view('customer.index');
   }
   public function getCustomerList(Request $request)
   {
      $data  = Customer::with('customertype')->where('is_deleted',0)->orderBy('created_at', 'desc')->get();
      return Datatables::of($data)
      ->addColumn('profile_image', function ($data) {
         if ($data->profile_image) {
            return '<img src="'.asset('profile_image/' . $data->profile_image).'" class="table-user-thumb"/>';
         } else {
            return '<img src="'.asset('img/customer.jpg').'" class="table-user-thumb"/>';
         }
      })
      ->addColumn('created_at', function ($data) {
      //   return $data->created_at;
           return Carbon::parse($data->created_at)->format('d M Y g:i A');
      })
     ->addColumn('is_blocked', function ($data) {
         return $data->is_blocked ? 
         '<div class="icon blockuser" data-isblock="unblocked" data-id="'.$data->customer_id.'"><i class="ik ik-toggle-left text-red f-35 text-center"></i></div>' : 
         '<div class="icon blockuser" data-isblock="blocked" data-id="'.$data->customer_id.'"><i class="ik ik-toggle-right text-green f-35 text-center"></i></div>';
      })
     ->addColumn('status', function ($data) {
         $status = '';
         if($data->status == "Active"){
            $status = '<span class="badge badge-success">Active</span>';
         } elseif ($data->status == "Inactive") {
            $status = '<span class="badge badge-danger">Inactive</span>';
         } else {
            $status = '<span class="badge badge-primary">Rejected</span>';
         }
            return $status; 
      })
      
      ->addColumn('action', function($data){
         return '<div class="table-actions">
                     <a title="Resect Password" href="'.url('customer/password-reset/'.$data->customer_id).'" ><i class="fas fa-key f-26 mr-15 text-green"></i></a>
                     <a title="Show" href="'.url('customer/view/'.$data->customer_id).'" ><i class="ik ik-eye f-26 mr-15 text-green d-none"></i></a>
                     <a title="Edit" href="'.url('customer/'.$data->customer_id).'" ><i class="ik ik-edit f-26 mr-15 text-green"></i></a>
                     <a title="Delete" href="#"  class="delete-item" data-id="'.$data->customer_id.'"><i class="ik ik-trash-2 f-26 text-red"></i></a>
                  </div>';
      })
      ->rawColumns(['profile_image', 'is_blocked','status','action'])
      ->make(true);
   }
   public function create() {
      $statusOptions = [
         'Active' => 'Active',
         'Inactive' => 'Inactive',
         // 'Rejected' => 'Rejected',
     ];
      $countries = Countries::where(['id' => 101])->pluck('name','id');
      // $countries = Countries::pluck('name','id');
      $customer_type = CustomerType::pluck('customer_type','customer_type_id');
      return view('customer.create', compact('customer_type','statusOptions','countries'));
   }
   public function store(Request $request) {
       // create customer 
       $validator = Validator::make($request->all(), [
         'name'   => 'required|string|max:255',
         'phone' => [
            'required',
            'digits:10',
            Rule::unique('customers')
                ->where(function ($query) {
                    $query->where('is_deleted', false);
                }),
        ],
         'email' => [
            'required',
            'email',
            'max:255',
            Rule::unique('customers')
                ->where(function ($query) {
                    $query->where('is_deleted', false);
                }),
        ],
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
               'phone_code'    => '+91',
               'phone'    => $request->phone,
               'customer_type'    => $request->customer_type,
               'dob'    => $request->dob,
               'pincode'    => $request->pincode,
               'gender'    => $request->gender,
               'country'    => $request->country,
               'state'    => $request->state,
               'city'    => $request->city,
               'referal_code'    => Str::random(10),
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
      try
      {
         $customer  = Customer::find($id);

            if($customer){
               //  return view('pages.ui.icons');
               return view('customer.show');
            }else{
               return redirect('404');
            }         
      }catch (\Exception $e) {
          $bug = $e->getMessage();
          return redirect()->back()->with('error', $bug);
      }
   }
   
   public function edit($id) {
      try
      {
         $customer  = Customer::with('customertype')->find($id);
            $states = [];
            $cities = [];
            if($customer){
               if($customer->city){
                  $cities = Cities::with('state')->findOrFail($customer->city);
                  // $countries = Countries::all();
                  $countries = Countries::where(['id' => 101])->get();
                  $states = States::where('country_id', $cities->state->country_id)->get();
               }else{
                  $countries = Countries::where(['id' => 101])->get();
               }
               $selectedCustomerType = $customer->customer_type;

               $customer_type = CustomerType::pluck('customer_type','customer_type_id');
               // echo "<pre>";print_r($states);die;
               return view('customer.edit', compact('customer','customer_type','selectedCustomerType','cities', 'countries', 'states'));
            }else{
               return redirect('404');
            }         
      }catch (\Exception $e) {
          $bug = $e->getMessage();
          return redirect()->back()->with('error', $bug);
      }
   }
   public function passwordReset($id) {
      try
      {
         $customer  = Customer::find($id);

            if($customer){
               return view('customer.password-reset',compact('customer'));
            }else{
               return redirect('404');
            }         
      }catch (\Exception $e) {
          $bug = $e->getMessage();
          return redirect()->back()->with('error', $bug);
      }
   }
   public function passwordUpdate(Request $request) {
      // create customer 
      $validator = Validator::make($request->all(), [
        'password'  => 'required|min:6|required_with:confirm_password|same:confirm_password',
    ]);
    
    if($validator->fails()) {
        return redirect()->back()->withInput()->with('error', $validator->messages()->first());
    }
    try
    {
        // update customer password
        $customer = Customer::find($request->customer_id);
         if ($customer) {
            $customer->update([
               'password' => Hash::make($request->password),  
               ]);
            return redirect('customer')->with('success', 'Password Reset Successfully!');
         } else{
            return redirect('customer')->with('error', 'Failed to password reset! Try again.');
        }
    }catch (\Exception $e) {
        $bug = $e->getMessage();
        return redirect()->back()->with('error', $bug);
    }
  }
   public function update(Request $request) {
      
      $CustomerVale = Customer::findOrFail($request->customer_id);
      $validator = Validator::make($request->all(), [
         'customer_id' => 'required',
         'name'        => 'required|string|max:255',
         'email' => [
            'required',
            'email',
            'max:255',
            Rule::unique('customers')
               ->ignore($CustomerVale->customer_id,'customer_id')
               ->where(function ($query) {
                  $query->where('is_deleted', false);
               }),
         ],
         'phone' => [
            'required',
            'digits:10',
            Rule::unique('customers')
               ->ignore($CustomerVale->customer_id,'customer_id')
               ->where(function ($query) {
                  $query->where('is_deleted', false);
               }),
         ],
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
               'dob'    => $request->dob,
               'pincode'    => $request->pincode,
               'gender'    => $request->gender,
               'country'    => $request->country,
               'state'    => $request->state,
               'city'    => $request->city,
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
   public function toggleBlockStatus(Request $request)
   {
      $customerId = $request->input('id');
      $toggleBlockStatus = $request->input('is_blocked');

      $customer = Customer::find($customerId);

      if ($customer) {
         if($toggleBlockStatus == 'blocked'){
            $customer->is_blocked = 1;
         } else {
            $customer->is_blocked = 0;
         }
         $customer->save();

         return response()->json(['success' => true]);
      }

      return response()->json(['success' => false], 404);
   }
   public function delete($id) {
     $CustomerData = Customer::where(['customer_id' => $id, 'is_deleted' => false])->first();
       if($CustomerData){
           $CustomerData->update(['is_deleted' => 1]);
           return response()->json(['success' => true]);
       }else{
         return response()->json(['success' => false], 404);
       }
   }
}
