<?php

namespace App\Models;

use App\Events\GlobalEvent;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Industry extends Model
{
    use HasFactory, Uuids, SoftDeletes;

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
        'name',
        'slug',
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
     * get the companies
     * @return HasMany
     */
    public function company(): HasMany
    {
        return $this->hasMany(Company::class);
    }

    /**
     * get the proposal_templates
     * @return HasMany
     */
    public function proposal_template(): HasMany
    {
        return $this->hasMany(ProposalTemplate::class);
    }

    /**
     * get the invoice_templates
     * @return HasMany
     */
    public function invoice_template(): HasMany
    {
        return $this->hasMany(InvoiceTemplate::class);
    }

    /**
     * get the need_templates
     * @return HasMany
     */
    public function need_template(): HasMany
    {
        return $this->hasMany(NeedTemplate::class);
    }

    /**
     * get the key_words
     * @return HasOne
     */
    public function key_word(): HasOne
    {
        return $this->hasOne(KeyWord::class);
    }

    /**
     * get the portal
     * @return HasOne
     */
    public function portal(): HasOne
    {
        return $this->hasOne(Portal::class);
    }
}
