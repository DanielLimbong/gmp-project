<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    public $timestamps = false;
    use HasFactory;

        protected $fillable = [
        'question',
        'weight',
        'area_id',
        'status',
        'numbering',
        ];

        public function areas(): BelongsTo{
        return $this->belongsTo(Area::class, 'area_id');
        }

        public function daily_inspection(): HasMany{
            return $this->hasMany(Daily_Inspection::class, 'question_id');
        }

        public function answers(): HasMany{
            return $this->hasMany(Answer::class, 'question_id');
        }
}
