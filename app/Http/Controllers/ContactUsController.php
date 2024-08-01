<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactUs;
use DataTables,Auth;

class ContactUsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

   public function index() {
      $id = 1;
      $contact_us =ContactUs::findOrFail($id);
      return view('contact_us.edit', compact('contact_us'));
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
      $id = 1;
      $contact_us =ContactUs::findOrFail($id);
      return view('contact_us.edit', compact('contact_us'));
   }
   public function update(Request $request) {
      $request->validate([
         // 'phone_number' => 'required|numeric|min:10',
         'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:20',
         'email' => 'required|email',
         'address' => 'required',
         'map_address' => 'required',
     ]);
     try{
      $contactUs = ContactUs::find($request->contact_us_id);
      if ($contactUs) {
         $contactUs->update([
            'phone_number' => $request->phone_number,
            'email'    => $request->email,
            'address' => $request->address,
            'map_address' => $request->map_address,
            ]);
         return redirect()->back()->with('success', 'Contact us updated successfully.');
      } else {
      return redirect()->back()->with('error', 'Contact us updated faild!');
      }
     }catch (\Exception $e) {
         $bug = $e->getMessage();
         // return redirect()->back()->with('error', $bug);
         return redirect()->back()->with('error', "Somthing went wrong, Please try again");
     }
   }
   public function destroy($id) {
      echo 'destroy';
   }
}
