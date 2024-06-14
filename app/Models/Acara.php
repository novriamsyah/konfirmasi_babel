<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acara extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function pesertas()
    {
        return $this->hasMany(Peserta::class);
    }
}
