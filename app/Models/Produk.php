<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Produk extends Model
{
    use HasFactory;
    protected $fillable = [
        'kodeProduk',
        'namaProduk',
        'hargaProduk',
        'userId',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
