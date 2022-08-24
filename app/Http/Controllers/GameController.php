<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameHistory;
use App\Models\Player;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    public function index(){
        return view('start');
    }

    public function startGame(Request $request,$id){
        $validator = Validator::make($request->all(),[
            '1stPlayer' => ['required'],
            '2ndPlayer' => ['required'],
            'bordLength' => ['required'],
        ]);

        if($validator->fails()){
            $data = ['error' => 'Please check the info !'];
            return Redirect::back()->withErrors($validator)->withInput();
        }else{
            $player1 = $request->input('1stPlayer');
            $player2 = $request->input('2ndPlayer');
            $bordLength = $request->input('bordLength');

            DB::beginTransaction();
            try {
                Game::where('id','=',$id)->update([
                                                'bordLength' => $bordLength,
                                                'max_move' => $bordLength,
                                                'status' => 1
                                            ]);
                $status = rand(0,1);

                Player::where('id','=',1)->update([
                                    'name' => $player1,
                                    'status' => $status
                                ]);

                Player::where('id','=',2)->update([
                                        'name' => $player2,
                                        'status' => ($status == 1)?$status:0
                                    ]);

                $result = GameHistory::truncate();

                DB::commit();
            }catch(Exception $e){
                DB::rollback();
                return ['error' => 'Please check the info !'];
            }

            if($result == true){
                $this->gameBord();
            }
        }
    }

    public function gameBord(){
        $gameInfo = Game::where('id','=',1)->first();
        $players = Player::all();
        return view('game', compact('gameInfo','players'));
    }

    public function createMove(Request $request){
        $box_id = $request->input('box_id');
        $player = $request->input('player_id');

        $check = $this->boxIdCheck($box_id);

        if($check > 0){
            return ['warning' => 'used'];
        }else{
            DB::beginTransaction();
            try {
                GameHistory::create([
                    'game_id' => 1,
                    'player_id' => $player,
                    'box_id' => $box_id,
                    'status' => 0
                ]);

                Player::where('id','=',$player)->update(['status' => 0]);
                $result = Player::where('id','!=',$player)->update(['status' => 1]);

                DB::commit();
            }catch(Exception $e){
                DB::rollback();
                return ['error' => 'Please check the info !'];
            }

            if($result == true){
                return ['success' => $result];
            }
        }
    }

    public function boxIdCheck($id){
        return GameHistory::where('box_id','=',$id)->count('id');
    }

    public function checkTurn(){
        return Player::where('status','=',1)->orderBy('id')->limit(1)->first();
    }
}
