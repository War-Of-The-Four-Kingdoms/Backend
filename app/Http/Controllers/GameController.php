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
        $leader_chars = Character::select('id','name','tribe','hp','gender','image_name','char_name')->where('is_leader',true)->get();
        $normal_chars = Character::select('id','name','tribe','hp','gender','image_name','char_name')->where('is_leader',false)->get();
        return response()->json(['leader' => $leader_chars, 'normal' => $normal_chars]);
    }

    public function getTopCards(Request $request){
        $topCards = Carddeck::where('game',Game::where('roomcode',$request['roomcode'])->first()->id)->where('in_use',false)->orderBy('order', 'asc')->limit($request->num)->get();
        return $topCards;
    }

    public function setNewOrder(Request $request){
        //neworder: [155,125,140] , drop: [177,156] , card_num: 5 , roomcode: 'asfasf'
        $indeck = Carddeck::where('game',Game::where('roomcode',$request['roomcode'])->first()->id)->where('in_use',false)->orderBy('order', 'asc')->get();
        foreach($indeck as $index=>$card){
            if($index>=$request->card_num){
                $card->order = $card->order-$request->drop->length;
                $card->save();
            }
        }
        $lastorder = Carddeck::where('game',Game::where('roomcode',$request['roomcode'])->first()->id)->where('in_use',false)->orderBy('order', 'desc')->first()->order;
        if($request->neworder->length != 0){
            foreach($request->neworder as $nindex=>$card_id) {
                Carddeck::where('game',Game::where('roomcode',$request['roomcode'])->first()->id)->where('id',$card_id)->update(['order' => $nindex+1]);
            }
        }
        if($request->neworder->length != 0){
            foreach($request->drop as $dindex=>$dcard_id) {
                Carddeck::where('game',Game::where('roomcode',$request['roomcode'])->first()->id)->where('id',$dcard_id)->update(['order' => $lastorder+$dindex+1]);
            }
        }
    }

    public function roomEnd(Request $request){
        Carddeck::where('game',Game::where('roomcode',$request['roomcode'])->first()->id)->delete();
        Game::where('roomcode',$request['roomcode'])->update(['is_end' => 1]);
        return response()->json(['status' => 200]);
    }

    public function drawCard(Request $request){
        $d_cards = Carddeck::where('game',Game::where('roomcode',$request['roomcode'])->first()->id)->where('in_use',false)->orderBy('order', 'asc')->limit($request->num)->get();
        $indeck = Carddeck::where('game',Game::where('roomcode',$request['roomcode'])->first()->id)->where('in_use',false)->orderBy('order', 'asc')->get();
        foreach($d_cards as $index=>$dcard){
            $dcard->info = Card::where('id',$dcard->card)->first();
        }
        foreach($indeck as $index=>$card){
            if($index<$request->num){
                $card->in_use = true;
                $card->order = 0;
            }else{
                $card->order = $card->order-$request->num;
            }
            $card->save();
        }
        return $d_cards;
    }

    public function openCard(Request $request){
        $open_card = Carddeck::where('game',Game::where('roomcode',$request['roomcode'])->first()->id)->where('in_use',false)->orderBy('order', 'asc')->first();
        $indeck = Carddeck::where('game',Game::where('roomcode',$request['roomcode'])->first()->id)->where('in_use',false)->orderBy('order', 'asc')->get();
        $lastorder = Carddeck::where('game',Game::where('roomcode',$request['roomcode'])->first()->id)->where('in_use',false)->orderBy('order', 'desc')->first()->order;
        foreach($indeck as $index=>$card){
            if($index<1){
                $card->order = $lastorder;
            }else{
                $card->order = $card->order-1;
            }
            $card->save();
        }
        $open_card->info = Card::where('id',$open_card->card)->first();
        return $open_card;
    }

    public function dropCard(Request $request){
        $card_drop = Carddeck::where('game',Game::where('roomcode',$request['roomcode'])->first()->id)->where('in_use',true)->whereIn('id',$request['cards'])->get();
        $lastorder = Carddeck::where('game',Game::where('roomcode',$request['roomcode'])->first()->id)->where('in_use',false)->orderBy('order', 'desc')->first()->order;
        foreach($card_drop as $index=>$card){
            $card->order = $lastorder+$index+1;
            $card->in_use = false;
            $card->save();
        }
        return response()->json(['status' => 200]);
    }

    public function updateCardInUse(Request $request){
        $card_update = Carddeck::where('game',Game::where('roomcode',$request['roomcode'])->first()->id)->where('in_use',false)->whereIn('id',$request['cards'])->get();
        foreach($card_update as $index=>$card){
            $card->order = 0;
            $card->in_use = true;
            $card->save();
        }
        return response()->json(['status' => 200]);
    }

    public function storeGameData(Request $request){
        $game = Game::create([
            'roomcode' => $request->room['code'],
            'maxplayer' => $request->room['max'],
            'turn' => $request->turn_count,
            'is_end' => false
        ]);
        foreach($request->room['players'] as $pl){
            Player::create([
                'game' => $game->id,
                'user' => User::where('uuid',$pl['uuid'])->first()->id,
                'character' => $pl['character']['id']??null,
                'role' => Role::where('name',$pl['role'])->first()->id,
                'remain_hp' => $pl['remain_hp']??null,
            ]);
        }
        $cards = Card::inRandomOrder()->get();
        foreach($cards as $index=>$card){
            $carddeck = Carddeck::create([
                'card' => $card->id,
                'game' => $game->id,
                'in_use' => false,
                'order' => $index+1
            ]);
            $carddeck->save();
        }
    }
}

