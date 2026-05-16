<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = ['item_name', 'category', 'status'];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}
