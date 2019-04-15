<?php

namespace App\Api\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Dingo\Api\Routing\Helpers;
use App\Models\Work;
use App\Models\Wage;
use App\Models\Balance;

class CustomerController extends Controller
{
    use Helpers;

    public function username(Request $request)
    {

    	if($q =$request->sf_code)
        {
             return Customer::where('sf_code', '=', "$q")->get([\DB::raw('name as text')]);
        }elseif($q=$request->get('q')){

           return Customer::where('id', '=', "$q")->get([\DB::raw('name as text')]);      
        }        	
    	
    }

    public function getWorkPrice(Request $request)
    {
    	$q = $request->get('q');
    	
    	return Work::where('id', '=', "$q")->get(['id', \DB::raw('price as text')]);
    }

    public function wage(Request $request)
    {
      //验证客户确实存在 
      if($customer=Customer::where('sf_code',$request->sf_code)->first()){
        $customer_id=$customer->id;
        $money=number_format($request->money,2);
        \DB::transaction(function ()use($request,$customer_id,$money) {
            Wage::create(['customer_id'=>$customer_id,'money'=>$money,'bark'=>$request->bark]);
            if($balance=Balance::where('customer_id',$customer_id)->first()){
                $balance->increment('balance',$money);
            }else{
                Balance::create(['customer_id'=>$customer_id,'balance'=>$money]);
            }

        });

      }else{
         return response()->json(['status'=>0,'msg'=>'添加失败！'],202);
      }

      return response()->json(['status'=>1,'msg'=>'添加成功！'],200);

    }
}
