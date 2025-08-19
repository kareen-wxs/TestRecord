<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'status',
    ];

    // Local scope for Allowed status
    public function scopeAllowed($query)
    {
        return $query->where('status', 'Allowed');
    }
}
