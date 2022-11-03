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
        $topCards = Carddeck::where('game',Game::where('roomcode',$request->room_code)->first()->id)->where('in_use',false)->orderBy('order', 'asc')->limit($request->num)->get();
        return $topCards;
    }

    public function setNewOrder(Request $request){
        //neworder: [155,125,140] , drop: [177,156] , card_num: 5 , room_code: 'asfasf'
        $first10c = Carddeck::where('game',Game::where('roomcode',$request->room_code)->first()->id)->where('in_use',false)->orderBy('order', 'asc')->limit(10)->get();
        if($request->neworder->length != 0){
            foreach($request->neworder as $noindex=>$card_id) {
                Carddeck::where('game',Game::where('roomcode',$request->room_code)->first()->id)->where('id',$card_id)->update(['order' => $noindex+1]);
            }
        }
        if($request->neworder->length != 0){
            foreach($request->drop as $dcard_id) {
                Carddeck::where('game',Game::where('roomcode',$request->room_code)->first()->id)->where('id',$dcard_id)->update(['order' => 99]);
            }
        }
        $newcards = Carddeck::where('game',Game::where('roomcode',$request->room_code)->first()->id)->where('in_use',false)->where('order', 99)->inRandomOrder()->limit($request->drop->length)->get();
        foreach ($first10c as $findex=>$fcard) {
            if($findex>=$request->card_num){
                $fcard->order = $fcard->order-$request->drop->length;
            }
            $fcard->save();
        }
        foreach($newcards as $nindex=>$ncard){
            $ncard->order = abs($nindex-10);
            $ncard->save();
        }
    }

    public function roomEnd(Request $request){
        Carddeck::where('game',Game::where('roomcode',$request->room_code)->first()->id)->delete();
        Game::where('roomcode',$request->room_code)->update(['is_end' => 1]);
        return response()->json(['status' => 200]);
    }

    public function drawCard(Request $request){
        $d_cards = Carddeck::where('game',Game::where('roomcode',$request->room_code)->first()->id)->where('in_use',false)->orderBy('order', 'asc')->limit($request->num)->get();
        $first10cards = Carddeck::where('game',Game::where('roomcode',$request->room_code)->first()->id)->where('in_use',false)->orderBy('order', 'asc')->limit(10)->get();
        $newcards = Carddeck::where('game',Game::where('roomcode',$request->room_code)->first()->id)->where('in_use',false)->where('order', 99)->inRandomOrder()->limit($request->num)->get();
        foreach($d_cards as $index=>$dcard){
            $dcard->info = Card::where('id',$dcard->card)->first();
        }
        foreach($first10cards as $index=>$card){
            if($index<$request->num){
                $card->in_use = true;
                $card->order = 99;
            }else{
                $card->order = $card->order-$request->num;
            }
            $card->save();
        }
        foreach($newcards as $index=>$ncard){
            $ncard->order = abs($index-10);
            $ncard->save();
        }
        return $d_cards;
    }

    public function openCard(Request $request){
        $open_card = Carddeck::where('game',Game::where('roomcode',$request->room_code)->first()->id)->where('in_use',false)->orderBy('order', 'asc')->first();
        $first10card = Carddeck::where('game',Game::where('roomcode',$request->room_code)->first()->id)->where('in_use',false)->orderBy('order', 'asc')->limit(10)->get();
        $newcard = Carddeck::where('game',Game::where('roomcode',$request->room_code)->first()->id)->where('in_use',false)->where('order', 99)->inRandomOrder()->first();
        foreach($first10card as $index=>$card){
            if($index<1){
                $card->order = 99;
            }else{
                $card->order = $card->order-$request->num;
            }
            $card->save();
        }
        $newcard->order = 10;
        $open_card->info = Card::where('id',$open_card->card)->first();
        return $open_card;
    }

    public function dropCard(Request $request){
        Carddeck::where('game',Game::where('roomcode',$request['roomcode'])->first()->id)->whereIn('id',$request['cards'])->update(['in_use' => 0]);
        return response()->json(['status' => 200]);
    }

    public function updateCardInUse(Request $request){
        Carddeck::where('game',Game::where('roomcode',$request['roomcode'])->first()->id)->whereIn('id',$request['cards'])->update(['in_use' => 1]);
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
                'order' => 99
            ]);
            if($index < 10){
                $carddeck->order = $index+1;
            }
            $carddeck->save();
        }
    }
}

