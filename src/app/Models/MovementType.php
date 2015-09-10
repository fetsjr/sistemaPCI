<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\MovementType
 *
 * @property integer $id
 * @property string $desc
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|Movement[] $movements
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\MovementType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\MovementType whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\MovementType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\MovementType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\MovementType whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\MovementType whereUpdatedBy($value)
 */
class MovementType extends AbstractBaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['desc'];

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // Has Many 1 -> 1..*
    // -------------------------------------------------------------------------

    /**
     * @return Collection
     */
    public function movements()
    {
        return $this->hasMany(Movement::class);
    }
}
