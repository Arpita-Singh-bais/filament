<?php

namespace App\Models;

use Filament\Notifications\Collection;
use Filament\Tables\Columns\Layout\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employee extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function state():BelongsTo{
        return $this->belongsTo(State::class);
    }
    public function city():BelongsTo{
        return $this->belongsTo(City::class);
    }
    public function department():BelongsTo{
        return $this->belongsTo(Department::class);
    }
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
   
    
}
