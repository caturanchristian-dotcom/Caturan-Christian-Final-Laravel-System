<?php

namespace App\Models;

use App\Models\Category;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model {
    protected $fillable = ['user_id', 'category_id', 'name', 'description', 'price', 'stock', 'image'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }
}

class Order extends Model {
    protected $fillable = ['user_id', 'total_amount', 'status'];

    public function items(): HasMany {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
