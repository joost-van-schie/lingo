<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    /**
     * The possible states of the game.
     */
    const STATE_ACTIVE = 'active';
    const STATE_WON = 'won';
    const STATE_LOST = 'lost';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'answer',
        'guessed_words',
        'attempts',
        'state'
    ];

    protected $casts = [
        'guessed_words' => 'array',
    ];

    /**
     * Scope a query to only include active games.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('state', self::STATE_ACTIVE);
    }

    /**
     * Scope a query to only include won games.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWon($query)
    {
        return $query->where('state', self::STATE_WON);
    }
}
