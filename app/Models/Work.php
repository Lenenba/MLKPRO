<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Work extends Model
{
    /** @use HasFactory<\Database\Factories\WorkFactory> */
    use HasFactory;


    protected $fillable = ['user_id', 'company_id', 'description', 'work_date', 'time_spent', 'is_completed', 'cost', 'location'];

    /**
     * Get the user that owns the work.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the company that owns the work.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the products used in the work.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_work')->withPivot('quantity_used', 'unit');
    }

    /**
     * Get the ratings for the work.
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(WorkerRating::class);
    }

    /**
     * Scope a query to order products by the most recent.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query): Builder
    {
        return $query->where('is_completed', true);
    }

    /**
     * Scope a query to order products by the most recent.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCustomer($query, $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    /**
     * Scope a query to order products by the most recent.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query, $days)
    {
        return $query->where('work_date', '>=', now()->subDays($days));
    }

    /**
     * Get the duration of the work in hours.
     *
     * @return float
     */
    public function getDurationInHours(): float
    {
        return round($this->time_spent / 60, 2);
    }

    /**
     * Get the formatted date of the work.
     *
     * @return string
     */
    public function getFormattedDate(): string
    {
        return $this->work_date->format('d M Y, H:i');
    }
}
