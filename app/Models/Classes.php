<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
{
    use HasFactory,SoftDeletes;
    protected $table ='classes';
    protected $fillable =[
        'class_name',
        'capacity',
        'price',
        'is_fulled',
        'timeFrom',
        'timeTo',

    ];
}
