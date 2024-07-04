<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @property-read mixed $name
 * @property-read mixed $total
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $orderItems
 * @property-read int|null $order_items_count
 * @method static \Database\Factories\OrderFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class Order extends Model
{
    use HasFactory;

    function orderItems() {
        return $this->hasMany(OrderItem::class);
    }

    // Accessor in laravel transforms an Eloquent attribute value that is been accessed. To create an accessor, there is a method named get{AttributeName}Attribute which returns the expected thing that you want when you access the attribute.
    // For more information, visit: https://dikshantraj2001.medium.com/accessors-and-mutators-in-laravel-1d4114dd3bc0

    public function getNameAttribute() {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getTotalAttribute() {
        return $this->orderItems->sum(fn(OrderItem $orderItem) => $orderItem->price * $orderItem->quantity);
    }
}
