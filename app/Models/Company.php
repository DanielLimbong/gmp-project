<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;
    public $incrementing = false;
            protected $fillable = [
            'id',
            'name',
            'company_code',
            ];
            protected $keyType = 'string';

            public function users(): HasMany{
                return $this->hasMany(User::class, 'company_code', 'company_code');
            }

            
}
