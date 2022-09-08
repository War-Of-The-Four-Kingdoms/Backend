<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use stdClass;

class GameController extends Controller
{
    public function getRoleList(Request $request){
        $all_roles = Role::select('name','extra_hp')->get();
        foreach ($all_roles as $r) {
            $roles[] = $r;
        }
        if($request->player_num > 4){
            $roles[] = Role::select('name','extra_hp')->where('name','villager')->first();
        }
        if($request->player_num > 5){
            if(rand(1,10) > 5){
                $roles[] = Role::select('name','extra_hp')->where('name','villager')->first();
            }else{
                $roles[] = Role::select('name','extra_hp')->where('name','noble')->first();
            }
        }
        return response()->json(['roles' => $roles]);
    }
}
