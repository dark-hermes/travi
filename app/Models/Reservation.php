<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'tour_package_id',
        'date',
        'quantity',
        'price',
        'quantity',
        'discount',
        'evidence',
        'status'
    ];

    /**
     * @var array<int, string>
     */
    protected $appends = [
        'discount_amount',
        'total_price',
    ];

    /**
     * Return the product's price multiplied by the discount divided by 100.
     *
     * @return float The discount amount
     */
    public function getDiscountAmountAttribute(): float
    {
        return $this->price * $this->discount / 100;
    }

    /**
     * > The `getTotalPriceAttribute()` function returns the price minus the discount amount
     *
     * @return float The total price of the product.
     */
    public function getTotalPriceAttribute(): float
    {
        return $this->price - $this->discount_amount;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tourPackage(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TourPackage::class);
    }
}
