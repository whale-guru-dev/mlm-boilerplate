<?php

namespace App\Http\Controllers\member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Adminsetting;
use App\Model\Transaction;
use App\Model\Income_membership;
use App\User;
use Auth;

class PaymentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('pages.member.purchase.purchase');
    }

    public function subscription()
    {
        // $adminsetting=Adminsetting::all()->last();

        // $percentperlevel=unserialize($adminsetting->percent_value);

        // $allusers=User::all();

        // foreach($allusers as $eachuser){
        //     $income[$eachuser->id]=$this->calc_income($percentperlevel,$eachuser->id,0,Adminsetting::all()->last()->membership_budget,0);
        // }

        // foreach($allusers as $eachuser){
        //     $income_membership=new Income_membership;
        //     $income_membership->user_id=$eachuser->id;
        //     $income_membership->income=$income[$eachuser->id];
        //     $income_membership->date=date('Y-m-d');
        //     $income_membership->status="Approved";
        //     $income_membership->save();
        // }
        $income_memberships=Income_membership::all();

        $users=User::where('path','LIKE', Auth::user()->path . '%' )->get();

        $user_array=$users->toArray();
        $i = 0;
        foreach ($user_array as $user) {
            $incomes[$i++]=Income_membership::where('user_id',$user['id'])->first();
        }
        return view('pages.member.incomecalc.membership',['income_memberships'=>$incomes]);
    }

    public function purchase_ewallet()
    {

    	$admin=User::where('is_admin',1)->first();
    	$membership=Adminsetting::all()->last()->membership_budget;

    	if(Auth::user()->ewallet_balance < $membership)
    	{
    		session(['status'=>'cancel']);
    		session(['message'=>'Woops! Ewallet does not have enough balance~']);

    	}

    	else
		{
			$admin_ewallet=$admin->ewallet_balance;	
			$admin_ewallet=$admin_ewallet+$membership;
			$admin->ewallet_balance=$admin_ewallet;
			$admin->save();
	
			
			$user=Auth::user();
			$user->ewallet_balance=$user->ewallet_balance-$membership;
			$user->save();
	
			$transaction=new Transaction;
			$transaction->from_user=Auth::user()->username;
			$transaction->to_user=$admin->username;
			$transaction->amount=$membership;
			$transaction->transaction_type_id=2;
			$transaction->save();
	
			session(['status'=>'success']);
			session(['message'=>'Congratulations! Successfully purchased by Ewallet~']);
		}
		return redirect()->route('purchase');
    }

    public function purchase_paypal_process($status)
    {	
    	if($status=='success'){

    			$admin=User::where('is_admin',1)->first();
    			$admin_ewallet=$admin->ewallet_balance;
    			$membership=Adminsetting::all()->last()->membership_budget;
    			$admin_ewallet=$admin_ewallet+$membership;
    			$admin->ewallet_balance=$admin_ewallet;
    			$admin->save();

    			$transaction=new Transaction;
    			$transaction->from_user=Auth::user()->username;
    			$transaction->to_user=$admin->username;
    			$transaction->amount=$membership;
    			$transaction->transaction_type_id=2;
    			$transaction->save();

	    		session(['status'=>'success']);
	    		session(['message'=>'Congratulations! Successfully purchased~']);
	    	}
    	else
    		{
    			session(['status'=>'cancel']);
    		    session(['message'=>'Woops! Purchase cancelled~']);
    		}
    	return redirect()->route('purchase');
    }


    // public function calc_income($percentperlevel,$id,$income,$budget,$percent_index)
    // {
    //     if(User::where('upline_id',$id)->count()>0)
    //     {
            
    //         $users=User::where('upline_id',$id)->get();
    //         $count=$users->count();
    //         $income=$income+$budget*$count*$percentperlevel[$percent_index]/100;
    //         $percent_index++;
    //         foreach($users as $user){
    //             return $this->calc_income($percentperlevel,$user->id,$income,$budget,$percent_index);
    //         }
    //     }
    //     else{
    //         return $income;
    //     }
    // }

}
