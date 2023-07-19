<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    public $incrementing = false;

    protected $fillable = [
        'area_name',
    ];
    protected $keyType = 'string';

    public function questions(){
        return $this->hasMany(Question::class, 'area_id');
    }

    public function answers(){
        return $this->hasMany(Answer::class, 'area_id');
    }

    public function daily_inspection_summary(){
        return $this->hasMany(DailyInspectionSummary::class, 'area_id');
    }
}
