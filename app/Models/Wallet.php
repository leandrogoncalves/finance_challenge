<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'document',
        'user_id',
    ];

    public function isShopAccount()
    {
        return $this->type === 'shop';
    }

    public function current_balance()
    {
        return $this->hasOne(Balance::class)->latest();
    }

    public function inbound_transactions()
    {
        return $this->hasMany(Transaction::class, 'payee')->orderBy('created_at', 'desc');
    }

    public function outgoing_transactions()
    {
        return $this->hasMany(Transaction::class, 'payer')->orderBy('created_at', 'desc');
    }
}
