<?php

namespace App\Http\Controllers;
use App\Models\Coupon;
use App\Models\UserCoupon;
use App\Models\Wallets;
use App\Models\Customer;
use Illuminate\Http\Request;
use DataTables,Auth;

class WalletsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

   public function index() {
      // return view('pages.ui.badges');
      return view('wallets.index');
   }
   public function getWalletsList(Request $request)
   {
      $data  = Wallets::with('customer')->where(['is_deleted'=> 0])->get();
      return Datatables::of($data)
      ->addColumn('action', function($data){
         return '<div class="table-actions">
                     <a href="'.url('wallets/view/'.$data->wallet_id).'" ><i class="ik ik-eye f-16 mr-15 text-green d-none"></i></a>
                     <a href="'.url('wallets/'.$data->wallet_id).'" ><i class="ik ik-edit-2 f-16 mr-15 text-green d-none"></i></a>
                     <a href="'.url('wallets/delete/'.$data->wallet_id).'"  ><i class="ik ik-trash-2 f-16 text-red"></i></a>
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
      $WalletsData = Wallets::where(['wallet_id' => $id, 'is_deleted' => false])->first();
        if($WalletsData){
            $WalletsData->update(['is_deleted' => 1]);
            return redirect('wallets')->with('success', 'Wallet amount deleted successfully.');
        }else{
            return redirect('wallets')->with('error', 'Wallet amount not found');
        }
   }
}

