<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = "clients";
    protected $fillable = ['email', 'join_date'];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
