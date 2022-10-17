<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Events\EventPaymentRegistered;

class Payment extends Model
{
    use HasFactory;

    protected $table = "payments";
    protected $fillable = [
        'uuid',
        'expires_at',
        'status',
        'clp_usd',
        'client_id'
    ];

    protected $dispatchesEvents = [
        'created' => EventPaymentRegistered::class,
    ];

    public function client()
    {
        return $this->belongsToMany(Client::class);
    }
}
