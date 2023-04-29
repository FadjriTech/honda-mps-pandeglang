<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Participant extends Model
{
    use HasFactory;
    protected $table = 'participant';
    protected $primaryKey = 'id';
    protected $guarded =  [''];
    public function motor(): HasMany
    {
        return $this->hasMany(Motor::class, 'participantId', 'id');
    }
}
