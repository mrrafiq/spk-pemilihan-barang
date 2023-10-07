<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArasValue extends Model
{
    use HasFactory;

    protected $table = "aras_value";

    protected $fillable = [
        "session_id",
        "barang_id",
        "criteria",
        "value"
    ];
}
