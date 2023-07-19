<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DailyInspectionSummary extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = [
    'created_at',
    'user_id',
    'area_id',
    'score_total',
    'updated_at',
    ];
    protected $keyType = 'string';

    public function users(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id');
    }
    public function areas(): BelongsTo{
        return $this->belongsTo(User::class, 'area_id');
    }

    public function daily_inspections(): HasMany{
        return $this->hasMany(DailyInspection::class, 'daily_inspection_summary_id');
    }
}
