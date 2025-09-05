<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'options',
        'end_time',
    ];

    protected $casts = [
        'options' => 'array', // convert JSON to array automatically
        'end_time' => 'datetime',
    ];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
