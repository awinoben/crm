<?php

namespace App\Models;

use App\Events\GlobalEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Note\Uuids\Uuids;

class Marketing extends Model
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
        'campaign_id',
        'tool_id',
        'frequency',
        'subject',
        'description',
        'is_sent',
        'is_closed',
        'queued_at',
        'callback_at',
        'schedule_at'
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
     * get tool
     * @return BelongsTo
     */
    public function tool(): BelongsTo
    {
        return $this->belongsTo(Tool::class);
    }

    /**
     * get company
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * get campaign
     * @return BelongsTo
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

}
