<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Issue extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = [
    'user_id',
    'question_id',
    'daily_inspection_summary_id',
    'issue',
    'status',
    'created_at',
    'updated_at',
    'updater_id'
    ];
    protected $keyType = 'string';

    public function users(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id');
    }
    public function questions(): BelongsTo{
        return $this->belongsTo(Question::class, 'question_id');
    }
    public function daily_inspection_summary(): BelongsTo{
        return $this->belongsTo(DailyInspectionSummary::class, 'daily_inspection_summary_id');
    }
}
