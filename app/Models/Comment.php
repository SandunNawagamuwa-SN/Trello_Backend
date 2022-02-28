<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['card_id', 'content'];

    /**
     * Get the card that owns the comment.
     */
    public function card()
    {
        return $this->belongsTo(Card::class);
    }

}
