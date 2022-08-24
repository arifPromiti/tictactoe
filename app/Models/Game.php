<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'bordLength',
        'max_move',
        'status'
    ];

    public function playerData(){
        return $this->hasMany(Player::class, 'game_id', 'id');
    }

    public function historyData(){
        return $this->hasMany(GameHistory::class, 'game_id', 'id');
    }
}
