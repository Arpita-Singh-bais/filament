<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    use HasFactory;
    protected $fillable = ['country_id', 'name'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'state_id');
    }   
    public function cities(): HasMany
    {
        return $this->hasMany(City::class, 'state_id');
    }
}

