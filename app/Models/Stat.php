<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    protected $fillable = [
        'user_id',
        'period_type',
        'start_date',
        'end_date',
        'avg_weight',
        'total_steps',
        'avg_steps',
        'total_calories',
        'avg_calories',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'avg_weight' => 'decimal:1',
        'total_steps' => 'integer',
        'avg_steps' => 'integer',
        'total_calories' => 'integer',
        'avg_calories' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
