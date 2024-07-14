<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutorial extends Model
{
    use HasFactory;
    // the default t able name is has single one in english, that's why i set it
    protected $table = "tutorial";
    // so i can use User::find(1) and tell it the primary key is the user_id column
    protected $primaryKey = 'tutorial_id';
    // so that i can use mass create and mass update
    protected $guarded = [];
}
