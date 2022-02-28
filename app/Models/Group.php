<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'board_id'];

    /**
     * Get the board that owns the group.
     */
    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    /**
     * Get the cards for the Board.
     */
    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
