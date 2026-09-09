<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'principal_amount',
        'interest_rate',
        'term_months',
        'status',
        'disbursement_date',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'disbursement_date' => 'date',
            'principal_amount' => 'decimal:2',
            'interest_rate' => 'decimal:2',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(LoanSchedule::class)->orderBy('installment_no');
    }

    public function repayments(): HasMany
    {
        return $this->hasMany(Repayment::class);
    }

    /**
     * Calculate remaining principal balance.
     */
    public function getRemainingBalanceAttribute(): string
    {
        $paid = $this->schedules->where('status', 'Paid')->sum('principal_due');

        return number_format($this->principal_amount - $paid, 2);
    }
}
