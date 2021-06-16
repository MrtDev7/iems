<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHetznerAccount;
use App\Models\Hetzner;
use Illuminate\Http\Request;

class HetznerController extends Controller
{
     public function getAccounts(){
        return Hetzner::latest()->get();
    }
    
    public function create(StoreHetznerAccount $request){
        $account = new Hetzner();
        $account->name = $request->name;
        $account->token = $request->token;
        $account->maxServerPerRequest = $request->maxServerPerRequest;
        $account->rootPass = $request->rootPass;
        $account->save();
        return $account;
    }

    public function update($id , StoreHetznerAccount $request){
        $account = Hetzner::find($id);
        $account->name = $request->name ?? $account->name;
        $account->token = $request->token ?? $account->token;
        $account->maxServerPerRequest = $request->maxServerPerRequest ?? $account->maxServerPerRequest;
        $account->rootPass = $request->rootPass ?? $account->rootPass;
        $account->save();
        return $account;
    }


    public function delete($id){
       $account = Hetzner::find($id);
       if(!$account){
           return 'account not found';
       }

       $account->delete();
       $account->save();
       return 'account deleted successfully';
    }
}

