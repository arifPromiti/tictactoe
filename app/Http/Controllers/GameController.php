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

    public function startGame(Request $request){
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
                Game::where('id','=',1)->update([
                                                'bordLength' => $bordLength,
                                                'max_move' => $bordLength*$bordLength,
                                                'status' => 1
                                            ]);
                $status = rand(0,1);

                Player::where('id','=',1)->update([
                                    'name' => $player1,
                                    'status' => $status
                                ]);
                GameHistory::where('status','=',0)->delete();

                $result = Player::where('id','=',2)->update([
                                            'name' => $player2,
                                            'status' => ($status == 1)?0:1
                                        ]);
                DB::commit();
            }catch(Exception $e){
                DB::rollback();
                return Redirect::back()->withErrors($e)->withInput();
            }

            if($result){
               return Redirect::route('Game.bord');
            }
        }
    }

    public function resetGame(){
        DB::beginTransaction();
        try {
            Game::where('id','=',1)->update(['status' => 1]);
            $status = rand(0,1);

            Player::where('id','=',1)->update(['status' => $status]);

            GameHistory::where('status','=',0)->delete();

            $result = Player::where('id','=',2)->update(['status' => ($status == 1)?0:1]);
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            return ['error' => $e];
        }

        if($result){
            return ['success' => 'Game reset successfully !'];
        }
    }

    public function gameBoard(){
        $gameInfo = $this->gameInfo();
        $players = Player::all();
        return view('game', compact('gameInfo','players'));
    }

    public function gameInfo(){
        return Game::where('id','=',1)->first();
    }

    public function playerInfo($id){
        return Player::where('id','=',$id)->first();
    }

    public function createMove(Request $request){
        $box_id_x = $request->input('box_id_x');
        $box_id_y = $request->input('box_id_y');
        $player = $request->input('player_id');

        $check = $this->boxIdCheck($box_id_x,$box_id_y);

        if($check > 0){
            return ['warning' => 'used'];
        }else{
            DB::beginTransaction();
            try {
                GameHistory::create([
                    'game_id' => 1,
                    'player_id' => $player,
                    'box_id_x' => $box_id_x,
                    'box_id_y' => $box_id_y,
                    'status' => 0
                ]);

                Player::where('id','=',$player)->update(['status' => 0]);
                $result = Player::where('id','!=',$player)->update(['status' => 1]);

                DB::commit();
            }catch(Exception $e){
                DB::rollback();
                return ['error' => 'Please check the info !'];
            }

            if($result){
                return ['success' => 'added !'];
            }
        }
    }

    public function boxIdCheck($x,$y){
        return GameHistory::where([['box_id_x','=',$x],['box_id_y','=',$y]])->count('id');
    }

    public function checkTurn(){
        return Player::where('status','=',1)->orderBy('id')->limit(1)->first();
    }

    public function getAllHistory($id){
        return GameHistory::where('player_id','=',$id)->get();
    }

    public function checkResults($id,$x,$y){
        $vertical = $this->verticalCheck($id,$y);
        $horizontal = $this->horizontalCheck($id,$x);
        $topDiagonal = $this->topLeftDiagonalCheck($id);
        $bottomDiagonal = $this->bottomLeftDiagonalCheck($id);
        $gameInfo = $this->gameInfo();
        $totalMove = GameHistory::where('status','=',0)->count('id');

        if($gameInfo->max_move == $totalMove){
            Game::where('id','=',1)->update(['status' => 3]);

            return ['sorry' => 'It is a Tie!'];
        }else if($horizontal == 1 || $vertical == 1 || $topDiagonal == 1 || $bottomDiagonal == 1){
            Game::where('id','=',1)->update(['status' => 2]);
            $player = $this->playerInfo($id);

            return ['success' => $player->name.' Congratulation !'];
        }else{
            return ['continue' => 1];
        }
    }

    public function verticalCheck($id,$y){
        $playerHistory = $this->getAllHistory($id);
        $gameInfo = $this->gameInfo();

        $a = 0;
        for ($i = 0; $i < $gameInfo->bordLength; $i++){
            foreach ($playerHistory as $row){
                if($row->box_id_x == $i && $row->box_id_y == $y){
                    $a++;
                }
            }
        }
        return ($a >= $gameInfo->bordLength)? 1:0;
    }

    public function horizontalCheck($id,$x){
        $playerHistory = $this->getAllHistory($id);
        $gameInfo = $this->gameInfo();

        $a = 0;
        for ($i = 0; $i < $gameInfo->bordLength; $i++){
            foreach ($playerHistory as $row){
                if($row->box_id_x == $x && $row->box_id_y == $i){
                    $a++;
                }
            }
        }
        return ($a >= $gameInfo->bordLength)? 1:0;
    }

    public function topLeftDiagonalCheck($id){
        $playerHistory = $this->getAllHistory($id);
        $gameInfo = $this->gameInfo();

        $a = 0;
        for($i = 0; $i < $gameInfo->bordLength; $i++){
            foreach ($playerHistory as $row){
                if($row->box_id_x == $i && $row->box_id_y == $i){
                    $a++;
                }
            }
        }

        return ($a == $gameInfo->bordLength)? 1:0;
    }

    public function bottomLeftDiagonalCheck($id){
        $playerHistory = $this->getAllHistory($id);
        $gameInfo = $this->gameInfo();

        $a = 0;
        $i = $gameInfo->bordLength;
        for($j = 0; $j < $gameInfo->bordLength;  $j++){
            $i = $i-1;
            foreach ($playerHistory as $row){
                if($row->box_id_x == $i && $row->box_id_y == $j){
                    $a++;
                }
            }
        }
        return ($a == $gameInfo->bordLength)? 1:0;
    }
}
