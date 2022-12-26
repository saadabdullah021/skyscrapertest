<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    protected $table = "leads";
    protected $fillable = ['FullName', "assigned_to", "status", "email", "phone_number", "user_email"];
}
