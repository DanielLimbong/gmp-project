<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyInspection extends Model
{
    use HasFactory;
        protected $fillable = [
        'daily_inspection_summary_id',
        'question_id',
        'answer_id',
        'score_point',
        ];

        public function questions(): BelongsTo{
            return $this->belongsTo(Question::class, "question_id");
        }

        public function answers(): BelongsTo{
            return $this->belongsTo(Answer::class,"answer_id" );
        }

        public function daily_inspection_summary(): BelongsTo{
            return $this->belongsTo(DailyInspectionSummary::class,'daily_inspection_summary_id');
        }
}
