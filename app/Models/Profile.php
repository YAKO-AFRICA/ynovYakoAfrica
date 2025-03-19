<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'roless';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'membre_id',
        'codereseau',
        'role'
    ];



}