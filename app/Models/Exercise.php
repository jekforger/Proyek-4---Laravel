<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'exercise_name',
        'time',
        'instructions',
        'set_type_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'set_type_id' => 'integer',
        ];
    }

    public function setType()
    {
        return $this->belongsTo(SetType::class);
    }

    public function bodyMassStandard()
    {
        return $this->belongsTo(BodyMassStandard::class);
    }
}
