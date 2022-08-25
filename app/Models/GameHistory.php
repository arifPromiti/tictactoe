<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'player_id',
        'box_id_x',
        'box_id_y',
        'status'
    ];

    public function playerData(){
        return $this->belongsTo(Player::class, 'player_id', 'id');
    }

    public function gameData(){
        return $this->belongsTo(Game::class, 'game_id', 'id');
    }
}
