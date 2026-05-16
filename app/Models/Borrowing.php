<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $fillable = ['user_id', 'inventory_id', 'borrowed_at', 'returned_at', 'status'];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
