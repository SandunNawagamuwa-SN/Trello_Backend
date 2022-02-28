<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    /**
     * Get the user that owns the board.
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the comments for the Card.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
