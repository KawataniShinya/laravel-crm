<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Purchase;

/**
 * App\Models\Customer
 *
 * @property int $id
 * @property string $name
 * @property string $kana
 * @property string $tel
 * @property string $email
 * @property string $postcode
 * @property string $address
 * @property string|null $birthday
 * @property int $gender
 * @property string|null $memo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\CustomerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereKana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Purchase> $purchases
 * @property-read int|null $purchases_count
 * @method static \Illuminate\Database\Eloquent\Builder|Customer searchCustomers($input = null)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Purchase> $purchases
 * @mixin \Eloquent
 */
class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'kana',
        'tel',
        'email',
        'postcode',
        'address',
        'birthday',
        'gender',
        'memo'
    ];

    public function scopeSearchCustomers($query, $input = null)
    {
        if(!empty($input)){
            if(
                Customer::where('kana', 'like', $input . '%' )
                    ->orWhere('tel', 'like', $input . '%')
                    ->exists()
            ){
                return $query->where('kana', 'like', $input . '%')->orWhere('tel', 'like', $input . '%');
            }
        }
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
