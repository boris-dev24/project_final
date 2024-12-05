<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    // les chamsp qui peuvent etre remplis dans le formulaire
    protected $fillable = ['name', 'email', 'subject', 'message'];
}
