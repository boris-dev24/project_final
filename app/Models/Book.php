<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // definir les champs voulu dans la page homepage 
    protected $fillable = ['title', 'author', 'year', 'summary', 'price', 'image_path'];
}
