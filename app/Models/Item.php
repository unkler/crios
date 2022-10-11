<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Purchase;
class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'memo',
        'price',
        'is_selling',
    ];

    public function purchase(): BelongsToMany
    {
        return $this->belongsToMany(Purchase::class)
            ->withPivot('quantity');
    }
}
