<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppSettings;
use DataTables,Auth;

class AppSettingsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

   public function index() {
      $id = 1;
      $app_settings =AppSettings::findOrFail($id);
      return view('aap_settings.edit', compact('app_settings'));
   }
   public function create() {
      echo 'create';
   }
   public function store(Request $request) {
      echo 'store';
   }
   public function show($id) {
      echo 'show';
   }
   public function edit($id) {
      $id = 1;
      $app_settings =AppSettings::findOrFail($id);
      return view('aap_settings.edit', compact('app_settings'));
   }
   public function update(Request $request) {
      $request->validate([
         'point_amount' => 'required|numeric|min:1|max:1000',
         'app_version' => 'required|numeric|min:1.0|',
         'maintenance_mode' => 'required',
         'maintenance_mode_message'   => 'nullable|required_if:maintenance_mode,1',
     ]);
     try{
      $appSettings = AppSettings::find($request->app_settings_id);
      if ($appSettings) {
         $appSettings->update([
            'point_amount' => $request->point_amount,
            'app_version'    => $request->app_version,
            'maintenance_mode' => $request->maintenance_mode,
            'maintenance_mode_message' => $request->maintenance_mode_message,
            ]);
         return redirect()->back()->with('success', 'App settings updated successfully.');
      } else {
      return redirect()->back()->with('error', 'App settings updated faild!');
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
