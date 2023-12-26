<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Uuid;

class Vehicle extends Model
{
    use HasFactory;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates name of the table.
     * 
     * @var string
     */
    protected $table = 'vehicles';

    /**
     * The primary key associated with the model.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'uuid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'plate',
        'motor_of_vehicle_id',
        'type_of_vehicle_id',
        'brand_of_vehicle_id',
        'driver_uuid',
        'owner_uuid',
        'color',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    /**
     * Boot function from laravel.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }

    /**
     * Get the motor that owns the vehicle.
     */
    public function motorOfVehicle(): BelongsTo
    {
        return $this->belongsTo(MotorOfVehicle::class);
    }

    /**
     * Get the type that owns the vehicle.
     */
    public function typeOfVehicle(): BelongsTo
    {
        return $this->belongsTo(TypeOfVehicle::class);
    }

    /**
     * Get the brand that owns the vehicle.
     */
    public function brandOfVehicle(): BelongsTo
    {
        return $this->belongsTo(BrandOfVehicle::class);
    }

    /**
     * Get the driver that owns the vehicle.
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the owner that owns the vehicle.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
