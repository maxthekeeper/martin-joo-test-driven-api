<?php

namespace App\Models;

use App\Enums\PaymentTypes;
use App\Models\Concerns\HasUuid;
use App\Models\Concerns\PaymentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;
    use HasUuid;

    protected $fillable = [
        'department_id',
        'full_name',
        'email',
        'job_title',
        'payment_type',
        'salary',
        'hourly_rate',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', 'uuid');
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function getPaymentTypeAttribute(): PaymentType
    {
        return PaymentTypes::from($this->original['payment_type'])
            ->makePaymentType($this);
    }
}
