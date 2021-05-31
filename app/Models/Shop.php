<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'cnpj',
        'user_id',
        'wallet_id',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
