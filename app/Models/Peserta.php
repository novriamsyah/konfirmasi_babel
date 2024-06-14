<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    public function acara()
    {
        return $this->belongsTo(Acara::class);
    }

    public function absen()
    {
        return $this->hasOne(Absen::class);
    }
}
