<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'name', 'term', 'year','flag','form_id'];

    public function form() {
        return $this->belongsTo(Form::class);
    }
}
