<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Answer extends Model
{
    use HasFactory;
    public $timestamps = false;

        protected $fillable = [
        'answer',
        'question_id',
        'point',
        ];

        public function areas(): BelongsTo{
            return $this->belongsTo(Area::class, 'area_id');
        }

        public function daily_inspections(): HasMany{
            return $this->hasMany(Daily_Inspection::class, 'answer_id');
        }

        public function question(): BelongsTo{
            return $this->belongsTo(Question::class, 'question_id');
        }
}
