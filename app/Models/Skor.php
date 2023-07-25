<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skor extends Model
{
    use HasFactory;
    protected $fillable = ['klub_id_1', 'klub_id_2', 'score_1', 'score_2'];

    public function klub1()
    {
        return $this->belongsTo(Klub::class, 'klub_id_1');
    }

    public function klub2()
    {
        return $this->belongsTo(Klub::class, 'klub_id_2');
    }
}
