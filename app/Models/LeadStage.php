<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Note\Uuids\Uuids;

class LeadStage extends Model
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
        'stage_id',
        'lead_id',
        'keywords',
        'products_and_services',
        'description',
        'level',
        'is_complete'
    ];

    /**
     * create casts
     */
    protected $casts = [
        'keywords' => 'array',
        'products_and_services' => 'array',
    ];

    /**
     * get leads
     * @return BelongsTo
     */
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    /**
     * get stage
     * @return BelongsTo
     */
    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
}
