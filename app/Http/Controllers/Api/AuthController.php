<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Models\Customer;
use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\File;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $deviceType = request()->input('device_type', 'Android');
        $validator = Validator::make($request->all(), [
            'username'   => 'required|string|max:20',
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
            'confirm_password'=> 'required',
            'password'  => 'required|min:6|required_with:confirm_password|same:confirm_password',

        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 400,
            ]);
        }
        try
        {
            // store customer information
            $customerId = Customer::insertGetId([
                  'username'     => $request->username,
                  'email'        => $request->email,
                  'phone_code'   => '+91',
                  'phone'        => $request->phone,
                  'customer_type'=> $request->customer_type,
                  'referal_code' => Str::random(10),
                  'password'     => Hash::make($request->password),
                  'api_token'    => Str::random(60),
                  'status'       => 'Active',
                  'device_type'  => $deviceType,
               ]);
            $customerData = Customer::where(['customer_id' => $customerId, 'is_deleted' => false])->first();
            return response()->json([
                'message' => "Customer registered successfully",
                'status' => 200,
                'data' => $customerData
            ]);
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return response()->json([
                'message' => $bug,
                'status' => 400,
            ]);
        }
    }
    public function login(Request $request)
    {
        // $accessToken = Auth::user()->createToken('authToken')->accessToken;
        // echo "<pre>";print_r($accessToken);die;
        $validator = Validator::make($request->all(), [
            'phone'     => 'required|digits:10',
            'password'  => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 400,
            ]);
        }
        try
        {
            $credentials = $request->only('phone', 'password');
            // if (Auth::guard('api')->attempt($credentials)) {
            //     $customer = Auth::guard('api')->user();
            // } 
            $customer = Customer::where(['phone' => $credentials['phone'], 'is_deleted' => false])->first();
            if($customer){
                if ($customer && Hash::check($credentials['password'], $customer->password)) {
                
                    if($customer->is_blocked){
                        return response()->json([
                            'message' => "Account has been blocked.",
                            'status' => 400,
                        ]);
                    }
                    $firstLoging = 'first_loggedin';
                    if($customer->is_first_login == 'first_loggedin'){
                        $firstLoging = 'done';
                    }
                    $customer->update([
                        'api_token'     => Str::random(60),
                        'is_logging'    => 1,
                        'is_first_login'=> $firstLoging,
                        'last_login_at' => Carbon::now()->format('Y-m-d H:i:s'),
                     ]);
                    return response()->json([
                        'message' => "Customer login successfully",
                        'status' => 200,
                        'data' => $customer
                    ]);
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Incorrect phone and password!!'
                    ]); // Forbidden
                }
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Incorrect phone and password!!'
                ]); // Forbidden
            }            
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return response()->json([
                'message' => $bug,
                'status' => 400,
            ]);
        }
    }
    public function socialLogin(Request $request){
        
        return response()->json([
            'message' => "Customer social login successfully",
            'status' => 200,
            // 'data' => $customer
        ]);
    }
    public function forgotPassword(Request $request){
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 400,
            ]);
        }
        $response = Password::sendResetLink($request->only('email'));
        return $response === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Password reset link sent.','status' => 200])
            : response()->json(['message' => 'Unable to send reset link.', 'status' => 400]);
    }
    public function profile(Request $request)
    {
        $customer = Auth::user();
        // $roles = $user->getRoleNames();
        // $permission = $user->getAllPermissions();
        if(!empty($customer)){
            return response([
                'status' => 200,
                'message' => 'Get Customer profile',
                'data' => $customer
            ]);
        } else {
            return response([
                'status' => 400,
                'message' => 'Customer profile not found!!',
            ]);
        }
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);

        // match old password
        if (Hash::check($request->old_password, Auth::user()->password)){

            User::find(auth()->user()->id)
            ->update([
                'password'=> Hash::make($request->password)
            ]);

            return response([
                        'message' => 'Password has been changed',
                        'status'  => 1
                    ]);
            
        }
            return response([
                        'message' => 'Password not matched!',
                        'status'  => 0
                    ]);
    }
    public function updateProfile(Request $request)
    {
        try {
            $customerProfile = Auth::user();
            if(!empty($customerProfile)){
                $validator = Validator::make($request->all(), [
                    'username'   => 'required|string|max:20',
                    'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('customers')
                        ->ignore($customerProfile->customer_id,'customer_id')
                        ->where(function ($query) {
                            $query->where('is_deleted', false);
                        }),
                    ],
                    'phone' => [
                    'required',
                    'digits:10',
                    Rule::unique('customers')
                        ->ignore($customerProfile->customer_id,'customer_id')
                        ->where(function ($query) {
                            $query->where('is_deleted', false);
                        }),
                    ],
                    'gender'        => 'nullable|in:M,F',
                    'dob' => [
                        'nullable',
                        'date',
                        function ($attribute, $value, $fail) {
                            $dob = \Carbon\Carbon::parse($value);
                            $minimumDate = \Carbon\Carbon::now()->subYears(10);
                            if ($dob->greaterThan($minimumDate)) {
                                $fail('The  Date of birth must be at least 10 years ago.');
                            }
                        },
                    ],
                    'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                    'country'       => 'nullable',
                    'state'         => 'nullable',
                    'city'          => 'nullable',
                    'pincode'       => 'nullable',
                ]);
                
                if ($validator->fails()) {
                    return response()->json([
                        'message' => $validator->errors()->first(),
                        'status' => 400,
                    ]);
                }
                if($request->input('username')){
                    $customerProfile->username = $request->input('username');
                }
                if($request->input('email')){
                    $customerProfile->email = $request->input('email');
                }
                if($request->input('phone')){
                    $customerProfile->phone = $request->input('phone');
                }
                if($request->input('gender')){
                    $customerProfile->gender = $request->input('gender');
                }
                if($request->input('dob')){
                    $customerProfile->dob = Carbon::parse($request->input('dob'))->format('Y-m-d');
                }
                if ($request->hasFile('profile_image')) {
                    
                    // Delete old image if exists
                    $imageFilePath = public_path('profile_image/').$customerProfile->profile_image;
                    if ($customerProfile->profile_image && $imageFilePath) {
                        if(File::exists($imageFilePath)) {
                            unlink($imageFilePath); //delete from storage
                        }
                    }                     
                    // Get the file from the request
                    $image = $request->file('profile_image');
                    
                    // Generate a file name
                    $ProfileImgName = time().'.'.$image->extension();
                    
                    // Move the image to the storage directory
                    $image->move(public_path('profile_image'), $ProfileImgName);
                                        
                    // Store new image
                    $customerProfile->profile_image = $ProfileImgName;
                }
                if($request->input('country')){
                    $customerProfile->country = $request->input('country');
                }
                if($request->input('state')){
                    $customerProfile->state = $request->input('state');
                }
                if($request->input('city')){
                    $customerProfile->city = $request->input('city');
                }
                if($request->input('pincode')){
                    $customerProfile->pincode = $request->input('pincode');
                }
                $customerProfile->save();
                return response([
                    'status'  => 200,
                    'message' => 'Profile updated successfully',
                ]);
            }
        } catch (\Throwable $th) {
            return response([
                'message' => 'Somthing went wrong, Please try again!',
                'status'  => 400
            ]);
        }
    }
    public function logout(Request $request)
    {
        try {
            $accessToken = Auth::user();
            if (!empty($accessToken)) {
                $accessToken->update(['api_token' => true]);
                return response([
                    'message' => 'Logged out succesfully!',
                    'status'  => 200
                ]);
            } else {
                return response([
                    'message' => 'Customer not found!!',
                    'status'  => 400
                ]);
            }
            
        } catch (\Throwable $th) {
            return response([
                'message' => 'Somthing went wrong, Please try again!',
                'status'  => 400
            ]);
        }
    }

}
