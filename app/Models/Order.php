<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $description
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Order cart()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order notCart()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @mixin \Eloquent
 */
class Order extends Model
{
    public const STATUS_CART = 'cart';
    public const STATUS_ORDER = 'order';
    public const STATUS_CANCEL = 'cancel';
    public const STATUS_DONE = 'done';

    protected $fillable = [
        'login', 'password', 'is_active', 'status', 'surname', 'name', 'patronymic', 'phone', 'email'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'status' => 'integer',
    ];


    /**
     * Get statuses
     *
     * @return array
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_CART,
            self::STATUS_ORDER,
            self::STATUS_CANCEL,
            self::STATUS_DONE
        ];
    }

    /**
     * Cart scope
     *
     * @param $query
     * @return mixed
     */
    public function scopeCart($query)
    {
        return $query->where('status', self::STATUS_CART);
    }

    /**
     * Not cart scope
     *
     * @param $query
     * @return mixed
     */
    public function scopeNotCart($query)
    {
        return $query->where('status', '<>', self::STATUS_CART);
    }

    /**
     * Product relations
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')->withPivot('count');
    }
}