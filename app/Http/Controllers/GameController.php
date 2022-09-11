<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Player;
use App\Models\Role;
use App\Models\User;
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

    public function storeGameData(Request $request){
        $game = Game::create([
            'roomcode' => $request->room->code,
            'maxplayer' => $request->room->max,
            'turn' => $request->turn_count,
            'is_end' => false
        ]);

        foreach($request->room->positions as $pl){
            Player::create([
                'game' => $game->id,
                'user' => User::where('uuid',$pl->uuid),
                'character' => $pl->character,
                'role' => $pl->role,
                'remain_hp' => $pl->remain_hp,
                'is_playing' => false
            ]);
        }

    }
}
