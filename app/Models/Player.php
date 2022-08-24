<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'name',
        'sign',
        'move_count',
        'status'
    ];

    public function historyData(){
        return $this->hasMany(GameHistory::class, 'player_id', 'id');
    }

    public function gameData(){
        return $this->belongsTo(Game::class, 'game_id', 'id');
    }
}
