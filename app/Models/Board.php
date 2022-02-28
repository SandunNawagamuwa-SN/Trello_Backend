<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    /**
     * Get the user that owns the board.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the groups for the Board.
     */
    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
