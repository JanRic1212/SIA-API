<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'poll_id',
        'voter',
        'choice',
    ];

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }
