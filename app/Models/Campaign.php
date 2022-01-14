<?php

namespace App\Models;

use App\Events\GlobalEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Note\Uuids\Uuids;

class Campaign extends Model
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
        'url',
        'description',
        'is_enabled',
        'start_date',
        'end_date',
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
     * get assigned_leads
     * @return HasMany
     */
    public function assigned_lead()
    {
        return $this->hasMany(AssignedLead::class)->latest();
    }

    /**
     * get company
     * @return BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class)->latest();
    }

    /**
     * get marketing
     * @return HasMany
     */
    public function marketing()
    {
        return $this->hasMany(Marketing::class)->latest();
    }
}
