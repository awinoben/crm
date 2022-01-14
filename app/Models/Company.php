<?php

namespace App\Models;

use App\Events\GlobalEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Note\Uuids\Uuids;
use World\Countries\Model\Country;

class Company extends Model
{
    use HasFactory, SoftDeletes, Uuids;

    // stop autoincrement
    public $incrementing = false;

    /**
     * type of auto-increment
     *
     * @string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'industry_id',
        'country_id',
        'user_id',
        'name',
        'slug',
        'email',
        'phone_number',
        'last_accessed_at',
    ];

    /**
     * trigger this to create a slug before
     * any save happens
     */
    protected $dispatchesEvents = [
        'saving' => GlobalEvent::class,
        'creating' => GlobalEvent::class,
        'updating' => GlobalEvent::class,
    ];

    /**
     * get user
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * get leads
     * @return HasMany
     */
    public function lead()
    {
        return $this->hasMany(Lead::class)->latest();
    }

    /**
     * get opportunity
     * @return HasMany
     */
    public function opportunity()
    {
        return $this->hasMany(OpportUnity::class)->latest();
    }

    /**
     * get promotion
     * @return HasMany
     */
    public function promotion()
    {
        return $this->hasMany(Promotion::class)->latest();
    }

    /**
     * get sale_funnels
     * @return HasMany
     */
    public function sale_funnel()
    {
        return $this->hasMany(SaleFunnel::class)->latest();
    }

    /**
     * get campaigns
     * @return HasMany
     */
    public function campaign()
    {
        return $this->hasMany(Campaign::class)->latest();
    }

    /**
     * get marketing
     * @return HasMany
     */
    public function marketing()
    {
        return $this->hasMany(Marketing::class)->latest();
    }

    /**
     * get sale
     * @return HasMany
     */
    public function sale()
    {
        return $this->hasMany(Sale::class)->latest();
    }

    /**
     * get social insights
     * @return HasMany
     */
    public function social_insight()
    {
        return $this->hasMany(SocialInsight::class)->latest();
    }

    /**
     * role todos
     * @return HasMany
     */
    public function todo()
    {
        return $this->hasMany(Todo::class)
            ->where('company_id', request()->user()->company_id)
            ->latest();
    }

    /**
     * get country
     * @return BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * get industry
     * @return BelongsTo
     */
    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    /**
     * get product
     * @return HasOne
     */
    public function product()
    {
        return $this->hasOne(Product::class);
    }
}
