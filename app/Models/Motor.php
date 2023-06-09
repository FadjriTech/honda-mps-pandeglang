<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Motor extends Model
{
    use HasFactory;
    protected $table = 'motor';
    protected $primaryKey = 'id';
    protected $guarded =  [''];

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class, 'participantId', 'id');
    }
}
