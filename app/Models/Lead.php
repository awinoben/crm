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

class Lead extends Model
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
        'country_id',
        'sale_funnel_id',
        'company_id',
        'lead_type_id',
        'name',
        'email',
        'phone_number',
        'age',
        'gender',
        'location',
        'professional',
        'social_media',
        'globe',
        'score',
        'is_lead',
        'is_contact',
        'is_customer',
        'is_active',
    ];

    /**
     * create casts
     */
    protected $casts = [
        'social_media' => 'array',
        'globe' => 'array',
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
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * get lead_type
     * @return BelongsTo
     */
    public function lead_type()
    {
        return $this->belongsTo(LeadType::class);
    }

    /**
     * get sales
     * @return HasMany
     */
    public function sale()
    {
        return $this->hasMany(Sale::class)->latest();
    }

    /**
     * get sale_funnel
     * @return BelongsTo
     */
    public function sale_funnel()
    {
        return $this->belongsTo(SaleFunnel::class);
    }

    /**
     * get assigned_lead
     * @return HasOne
     */
    public function assigned_lead()
    {
        return $this->hasOne(AssignedLead::class);
    }

    /**
     * get lead_stages
     * @return HasMany
     */
    public function lead_stage()
    {
        return $this->hasMany(LeadStage::class)->oldest('level');
    }

    /**
     * get country
     * @return BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
