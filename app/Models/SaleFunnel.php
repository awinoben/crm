<?php

namespace App\Models;

use App\Events\GlobalEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Note\Uuids\Uuids;

class SaleFunnel extends Model
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
        'company_id',
        'name',
        'slug',
        'url'
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
     * get company
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * get leads
     * @return HasMany
     */
    public function lead(): HasMany
    {
        return $this->hasMany(Lead::class)->latest();
    }

    /**
     * get social insights
     * @return HasMany
     */
    public function social_insight(): HasMany
    {
        return $this->hasMany(SocialInsight::class)->latest();
    }

    /**
     * get tips
     * @return HasMany
     */
    public function tip(): HasMany
    {
        return $this->hasMany(Tip::class)->latest();
    }
}
