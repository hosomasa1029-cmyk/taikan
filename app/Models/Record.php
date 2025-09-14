<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'weight',
        'steps',
        'calories',
    ];

    protected $casts = [
        'date' => 'date',
        'weight' => 'decimal:1',
        'steps' => 'integer',
        'calories' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
