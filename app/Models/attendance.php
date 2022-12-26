<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendance extends Model
{
    use HasFactory;

    protected $table = "attendances";
    protected $fillable = [
        "user_email",
        "total_time",
        "day",
        "time_in",
        "time_out"

    ];
}
