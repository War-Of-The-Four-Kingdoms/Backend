<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Carddeck;
use App\Models\Character;
use App\Models\Game;
use App\Models\Player;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

    public function getCharacterList(Request $request){
        $leader_chars = Character::select('id','name','tribe','hp','gender','image_name')->where('is_leader',true)->get();
        $normal_chars = Character::select('id','name','tribe','hp','gender','image_name')->where('is_leader',false)->get();
        return response()->json(['leader' => $leader_chars, 'normal' => $normal_chars]);
    }

    public function drawCard(Request $request){
        $d_cards = Carddeck::where('game',Game::where('roomcode',$request->room_code)->first()->id)->where('in_use',false)->inRandomOrder()->limit(4)->get();
        foreach($d_cards as $d_card){
            $d_card->in_use = true;
            $d_card->save();
        }
        return $d_cards;
    }

    public function storeGameData(Request $request){
        $game = Game::create([
            'roomcode' => $request->room['code'],
            'maxplayer' => $request->room['max'],
            'turn' => $request->turn_count,
            'is_end' => false
        ]);
        foreach($request->room['positions'] as $pl){
            Player::create([
                'game' => $game->id,
                'user' => User::where('uuid',$pl['uuid'])->first()->id,
                'character' => $pl['character']['id'],
                'role' => Role::where('name',$pl['role'])->first()->id,
                'remain_hp' => $pl['remain_hp'],
                'is_playing' => false
            ]);
        }
        $cards = Card::all();
        $symbols = array('club','diamond','heart','spade');
        $codes = array('2','3','4','5','6','7','8','9','10','J','Q','K','A');
        foreach($cards as $card){
            for($i=0;$i<$card->count;$i++){
                $sym = $symbols[array_rand($symbols,1)];
                $carddeck = Carddeck::create([
                    'card' => $card->id,
                    'game' => $game->id,
                    'in_use' => false,
                    'symbol' => $sym,
                    'code' => $codes[array_rand($codes,1)],
                ]);
                $carddeck->save();
            }
        }

    }

}
