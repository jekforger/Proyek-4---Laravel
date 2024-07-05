<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailAchievement extends Model
{
    use HasFactory;

    protected $fillable = [
        "status",
        "achievement_id",
        "exercise_id",
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'status' => 'boolean',
            'achievement_id' => 'integer',
            'exercise_id' => 'integer',
        ];
    }

    public function achievement()
    {
        return $this->belongsTo(Achievement::class);
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
}
