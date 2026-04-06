<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function scopeSchools(Builder $query): Builder
    {
        $schools = config('hris.department_schools', []);

        if (empty($schools)) {
            return $query;
        }

        return $query->whereIn('name', $schools);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
