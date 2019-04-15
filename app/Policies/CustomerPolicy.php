<?php

namespace App\Policies;

use App\User;
use App\Models\Customer;
use App\Models\Area;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    protected $area_ids=[];

    public function __construct(Area $area ,User $user)
    {
        if ($user->slug===1) {
            return true;
        }

        foreach ($user->roles as $item) {
            if ($item->slug=='shopadmin') {
                $this->area_ids[]='shopadmin';
            }else{
                $this->area_ids[]=$area->where('area',$item->name)->first()->id;
            }
        }
        
    }

    public function access(Customer $customer)
    {
        return in_array($customer->area_id,$this->area_ids);
    }

    public function isShopAdmin()
    {
        return in_array('shopadmin',$this->area_ids);
    }

   
}
