<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    // incementing digunakan jiga primary key bertipe data integer
    public $incrementing = false;
    public $timestamps = false;
    
}
