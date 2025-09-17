<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Audit extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'solicitud_id',
        'event',
        'changes',
        'ip',
        'user_agent',
        'actor_type',
        'actor_id',
    ];

    protected $casts = [
        'changes' => 'array',
    ];
}
