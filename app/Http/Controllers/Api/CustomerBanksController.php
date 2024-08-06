<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;
use App\Models\Customer;
use App\Models\UserBank;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CustomerBanksController extends Controller
{
    public function addBank(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|in:Bank Account,UPI,Google Pay,PhonePe,Paytm',
            'account_holder_name' => 'required|string|max:20',
            'upi' => 'nullable|required_if:payment_method,UPI',
            'googlepay' => 'nullable|required_if:payment_method,Google Pay',
            'phonepe' => 'nullable|required_if:payment_method,PhonePe',
            'paytm' => 'nullable|required_if:payment_method,Paytm',
            'bank_name' => 'nullable|required_if:payment_method,Bank Account',
            'account_type' => 'nullable|required_if:payment_method,Bank Account|in:Saving,Current',
            'account_number' => 'nullable|required_if:payment_method,Bank Account',
            'ifsc_code' => 'nullable|required_if:payment_method,Bank Account',
            'document' => 'required_if:payment_method,Bank Account|mimes:jpeg,png,jpg,pdf|max:2048',
            'scanner_code_photo' => 'required_if:payment_method,UPI,Google Pay,PhonePe,Paytm|mimes:jpeg,png,jpg|max:2048',
        ],[
            'payment_method.required' => "Please select payment method",
            'payment_method.unique' => "This payment method already exists",
            'payment_method.in' => "Please select valid payment method",
            'bank_name.required_if' => "Please enter bank name",
            'upi.required_if' => "Please enter your UPI details",
            'googlepay.required_if' => "Please enter your Google Pay details",
            'phonepe.required_if' => "Please enter your PhonePe details",
            'paytm.required_if' => "Please enter your Paytm details",
            'account_holder_name.required' => "Please enter account holder name",
            'document.required' => "Please upload bank related document",
            'document.required_if' => 'Please upload the passbook photo when the payment method is Bank.',
            'document.mimes' => 'The passbook photo must be a file of type: jpeg, png, jpg, pdf.',
            'document.max' => 'The passbook photo may not be greater than 2MB.',
            'scanner_code_photo.required_if' => 'Please upload the Scanner QR code photo',
            'scanner_code_photo.mimes' => 'The Scanner QR code photo must be a file of type: jpeg, png, jpg.',
            'scanner_code_photo.max' => 'The Scanner QR code photo may not be greater than 2MB.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 400,
            ]);
        }
        $bodyParams = $request->all();
        $authorizationHeader = $request->header('Authorization');
        $customerToken = Str::replaceFirst('Bearer ', '', $authorizationHeader);
        DB::beginTransaction();
        try {
            $Customer  = Customer::where(['api_token' => $customerToken,'is_deleted'=> 0])->first();
            if(!empty($Customer)){
                $UserBank = UserBank::where(['user_id' => $Customer->customer_id, 'payment_method' => $request->payment_method,'is_deleted' => false])->get();
                if(count($UserBank) > 0){
                    return response()->json([
                        'status' => 400,
                        'message' => "This payment method already added!",
                    ]);
                }
                $documentName = '';
                if($request->payment_method == "Bank Account"){
                    
                    if ($request->hasFile('document')) {
                        // Get the file from the request
                        $image = $request->file('document');
                        // Generate a file name
                        $documentName = time().'.'.$image->extension();
                        // Move the image to the storage directory
                        $image->move(public_path('bank_document'), $documentName);
                    }
                } else {
                    if ($request->hasFile('scanner_code_photo')) {
                    
                        if ($request->hasFile('scanner_code_photo')) {
                            // Get the file from the request
                            $image = $request->file('scanner_code_photo');
                            // Generate a file name
                            $documentName = time().'.'.$image->extension();
                            // Move the image to the storage directory
                            $image->move(public_path('bank_document'), $documentName);
                        }
                    }
                }
                $bankId = UserBank::insertGetId([
                    'user_id'              => $Customer->customer_id,
                    'payment_method'       => $request->payment_method,
                    'account_holder_name'  => $request->account_holder_name,
                    'upi'                  => (isset($request->upi)) ? $request->upi : NULL,
                    'googlepay'            => (isset($request->googlepay)) ? $request->googlepay : NULL,
                    'phonepe'              => (isset($request->phonepe)) ? $request->phonepe : NULL,
                    'paytm'                => (isset($request->paytm)) ? $request->paytm : NULL,
                    'bank_name'            => (isset($request->bank_name)) ? $request->bank_name : NULL,
                    'account_type'         => (isset($request->account_type)) ? $request->account_type : NULL,
                    'account_number'       => (isset($request->account_number)) ? $request->account_number : NULL,
                    'ifsc_code'            => (isset($request->ifsc_code)) ? $request->ifsc_code : NULL,
                    'document'             => $documentName,
                ]);
                DB::commit();
                return response()->json([
                    'message' => "Your bank details have been successfully submitted.",
                    'status'  => 200,
                    'data'    => $bankId,
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => "Customer not found!!",
                ]);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            $bug = $th->getMessage();
            return response()->json([
                'status' => 400,
                'message' => "Something went wront Please try again",
            ]);
        }
    }

    public function bankList(Request $request)
    {
        try {       
            $Customer = Auth::user();
            if(!empty($Customer)){
                $CustomerBank = UserBank::where(['user_id' => $Customer->customer_id, 'is_deleted' => false])->get();
                if(!empty($CustomerBank) > 0){
                    $UpdateBank = array();
                    foreach ($CustomerBank as $key => $BankData) {
                        $BankData->documentURL = asset('bank_document/'.$BankData->document);
                        $UpdateBank[] = $BankData;
                    }
                    return response()->json([
                        'message' => "Customer bank listing",
                        'status' => 200,
                        'data' => $UpdateBank
                    ]);
                } else{
                    return response()->json([
                        'message' => "Customer bank not found",
                        'status' => 400,
                    ]);
                }
            }
        } catch (\Throwable $th) {
            return response([
                'message' => 'Somthing went wrong, Please try again!'.$th,
                'status'  => 400
            ]);
        }
    }
    public function updateBank(Request $request){
        $validator = Validator::make($request->all(), [
            'bank_id' => 'required',
            'payment_method' => 'required|in:Bank Account,UPI,Google Pay,PhonePe,Paytm',
            'account_holder_name' => 'required|string|max:20',
            'upi' => 'nullable|required_if:payment_method,UPI',
            'googlepay' => 'nullable|required_if:payment_method,Google Pay',
            'phonepe' => 'nullable|required_if:payment_method,PhonePe',
            'paytm' => 'nullable|required_if:payment_method,Paytm',
            'bank_name' => 'nullable|required_if:payment_method,Bank Account',
            'account_type' => 'nullable|required_if:payment_method,Bank Account|in:Saving,Current',
            'account_number' => 'nullable|required_if:payment_method,Bank Account',
            'ifsc_code' => 'nullable|required_if:payment_method,Bank Account',
            'document' => 'nullable|mimes:jpeg,png,jpg,pdf|max:2048',
            'scanner_code_photo' => 'nullable|mimes:jpeg,png,jpg|max:2048',
        ],[
            'payment_method.required' => "Please select payment method",
            'payment_method.unique' => "This payment method already exists",
            'payment_method.in' => "Please select valid payment method",
            'bank_name.required_if' => "Please enter bank name",
            'upi.required_if' => "Please enter your UPI details",
            'googlepay.required_if' => "Please enter your Google Pay details",
            'phonepe.required_if' => "Please enter your PhonePe details",
            'paytm.required_if' => "Please enter your Paytm details",
            'account_holder_name.required' => "Please enter account holder name",
            'document.required' => "Please upload bank related document",
            'document.required_if' => 'Please upload the passbook photo when the payment method is Bank.',
            'document.mimes' => 'The passbook photo must be a file of type: jpeg, png, jpg, pdf.',
            'document.max' => 'The passbook photo may not be greater than 2MB.',
            'scanner_code_photo.required_if' => 'Please upload the Scanner QR code photo',
            'scanner_code_photo.mimes' => 'The Scanner QR code photo must be a file of type: jpeg, png, jpg.',
            'scanner_code_photo.max' => 'The Scanner QR code photo may not be greater than 2MB.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 400,
            ]);
        }
        $bodyParams = $request->all();
        $authorizationHeader = $request->header('Authorization');
        $customerToken = Str::replaceFirst('Bearer ', '', $authorizationHeader);
        DB::beginTransaction();
        try {
            $Customer  = Customer::where(['api_token' => $customerToken,'is_deleted'=> 0])->first();
            if(!empty($Customer)){
                $UserBank = UserBank::where(['bank_id' => $request->bank_id,'user_id' => $Customer->customer_id,'is_deleted' => false])->first();
                if(empty($UserBank)){
                    return response()->json([
                        'status' => 400,
                        'message' => "Bank not found!!",
                    ]);
                }
                if($UserBank->payment_method != $request->payment_method){
                    return response()->json([
                        'status' => 400,
                        'message' => "Paymet method invalid!",
                    ]);
                }
                if($request->input('account_holder_name')){
                    $UserBank->account_holder_name = $request->input('account_holder_name');
                }
                if($request->payment_method == "Bank Account"){
                    
                    if ($request->hasFile('document')) {
                        
                        $documentFilePath = public_path('bank_document/').$UserBank->document;
                        if ($UserBank->document && $documentFilePath) {
                            if(File::exists($documentFilePath)) {
                                unlink($documentFilePath);
                            }
                        }  
                        // Get the file from the request
                        $image = $request->file('document');
                        // Generate a file name
                        $documentName = time().'.'.$image->extension();
                        // Move the image to the storage directory
                        $image->move(public_path('bank_document'), $documentName);
                        $UserBank->document = $documentName;
                    }
                    if($request->input('bank_name')){
                        $UserBank->bank_name = $request->input('bank_name');
                    }
                    if($request->input('account_type')){
                        $UserBank->account_type = $request->input('account_type');
                    }
                    if($request->input('account_number')){
                        $UserBank->account_number = $request->input('account_number');
                    }
                    if($request->input('ifsc_code')){
                        $UserBank->ifsc_code = $request->input('ifsc_code');
                    }
                } else {
                    if ($request->hasFile('scanner_code_photo')) {
                        $documentFilePath = public_path('bank_document/').$UserBank->document;
                        if ($UserBank->document && $documentFilePath) {
                            if(File::exists($documentFilePath)) {
                                unlink($documentFilePath);
                            }
                        }  
                        // Get the file from the request
                        $image = $request->file('scanner_code_photo');
                        // Generate a file name
                        $documentName = time().'.'.$image->extension();
                        // Move the image to the storage directory
                        $image->move(public_path('bank_document'), $documentName);
                        $UserBank->document = $documentName;
                    }
                    if($request->input('upi')){
                        $UserBank->upi = $request->input('upi');
                    }
                    if($request->input('googlepay')){
                        $UserBank->googlepay = $request->input('googlepay');
                    }
                    if($request->input('phonepe')){
                        $UserBank->phonepe = $request->input('phonepe');
                    }
                    if($request->input('paytm')){
                        $UserBank->paytm = $request->input('paytm');
                    }
                }
                $UserBank->save();
                DB::commit();
                return response()->json([
                    'message' => "Curstomer bank updated successfully",
                    'status'  => 200,
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => "Customer not found!!",
                ]);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'message' => "Somthing went wrong, Please try again!".$th,
                'status'  => 400,
            ]);
        }
    }
    
    public function deleteBank(Request $request){
        $validator = Validator::make($request->all(), [
            'bank_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 400,
            ]);
        }
        DB::beginTransaction();
        try {
            $BankData  = UserBank::where(['bank_id' => $request->bank_id,'is_deleted' => false])->first();
            if(!empty($BankData)){
            
                $BankData->update(['is_deleted' => true]);
                DB::commit();
                return response()->json([
                    'message' => "Curstomer payment method deleted successfully",
                    'status'  => 200,
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => "Customer payment method not found!!",
                ]);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'message' => "Somthing went wrong, Please try again!",
                'status'  => 400,
            ]);
        } 
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required | string ',
            'email'    => 'required | email | unique:users',
            'password' => 'required | confirmed',
            'role'     => 'required'
        ]);
        
        // store user information
        $user = User::create([
                    'name'     => $request->name,
                    'email'    => $request->email,
                    'password' => Hash::make($request->password)
                ]);

        // assign new role to the user
        $role = $user->assignRole($request->role);

        if($user){
            return response([
                'message' => 'User created succesfully!',
                'user'    => $user,
                'success' => 1
            ]);
        }

        return response([
                'message' => 'Sorry! Failed to create user!',
                'success' => 0
            ]);
    }

    public function profile($id, Request $request)
    {
        $user = User::find($id);
        if($user)
            return response(['user' => $user,'success' => 1]);
        else
            return response(['message' => 'Sorry! Not found!','success' => 0]);
    }


    public function delete($id, Request $request)
    {
        $user = User::find($id);

        if($user){
            $user->delete();
            return response(['message' => 'User has been deleted','success' => 1]);
        }
        else
            return response(['message' => 'Sorry! Not found!','success' => 0]);
    }


    public function changeRole($id,Request $request)
    {
        $request->validate([
            'roles'     => 'required'
        ]);
        
        // update user roles
        $user = User::find($id);
        if($user){
            // assign role to user
            $user->syncRoles($request->roles);    
            return response([
                'message' => 'Roles changed successfully!',
                'success' => 1
            ]);
        }

        return response([
                'message' => 'Sorry! User not found',
                'success' => 0
            ]);
    }
}
