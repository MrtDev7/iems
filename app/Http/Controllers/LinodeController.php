<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Linode;
use App\Http\Controllers\Controller;

class LinodeController extends Controller
{
          public function getLinodes()
    {
        
        $data = Linode::latest()->get();
        return response()->json($data, 200); ;
    }

    public function getLinodeById($linodeId)
    {
        $linode = Linode::find($linodeId);
        return $linode;
    }

    public function create(Request $request)
    {
         $linode = new Linode();
        $linode->token = $request->token;
        $linode->name = $request->name;
        $linode->rootPass = $request->rootPass;
        $linode->save();
        return $linode;
    }

    public function delete($linodeId)
    {
        $linode = Linode::find($linodeId);

        if(!$linode){
            return 'not found';
        }

        $linode->delete();
        $linode->save();
        $linode = Linode::find($linodeId);
        if(!$linode){
            return 'linode deleted successfully';
        }
        
    }

    public function update($linodeId,Request $request )
    {
        $linode = Linode::find($linodeId);
        $linode->token = $request->tokens ?? $linode->token;
        $linode->maxDropletsPerRequest = $request->maxDropletsPerRequest ?? $linode->maxDropletsPerRequest;
        $linode->rootPass = $request->rootPass ?? $linode->rootPass;
        $linode->name = $request->name ?? $linode->name;
        $linode->token = $request->token ?? $linode->token;
        $linode->save();
        return $linode;
    }
}
