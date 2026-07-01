<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'compare_price',
        'stock_quantity',
        'sku',
        'image',
        'gallery',
        'status',
        'featured',
        'views',
    ];

    protected $casts = [
        'gallery' => 'array',
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getStockStatusAttribute()
    {
        if ($this->stock_quantity > 10) return 'In Stock';
        if ($this->stock_quantity > 0) return 'Low Stock';
        return 'Out of Stock';
    }

    public function getRouteKeyName()
    {
        return 'slug';
        return 'id';
    }
}