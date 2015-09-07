<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asoc',
        'priority',
        'desc',
        'stock',
        'minimun',
        'due',
    ];

    /**
     * Atributos que deben ser mutados a dates.
     * dates se refiere a Carbon\Carbon dates.
     * En otras palabras, genera una instancia
     * de Carbon\Carbon para cada campo.
     *
     * @var array
     */
    protected $dates = ['due'];

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // Belongs to 1..* -> 1
    // -------------------------------------------------------------------------

    /**
     * @return SubCategory
     */
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    /**
     * @return Maker
     */
    public function maker()
    {
        return $this->belongsTo(Maker::class);
    }

    /**
     * @return ItemType
     */
    public function type()
    {
        return $this->belongsTo(ItemType::class);
    }

    // -------------------------------------------------------------------------
    // Belongs to many
    // -------------------------------------------------------------------------

    /**
     * @return Collection
     */
    public function depots()
    {
        return $this->belongsToMany(Depot::class);
    }

    /**
     * Relacion unaria.
     * @return Collection
     */
    public function dependsOn()
    {
        return $this->belongsToMany(Item::class);
    }

    /**
     * @return Collection
     */
    public function petitions()
    {
        return $this->belongsToMany(Petition::class)->withPivot('quantity');
    }

    /**
     * @return Collection
     */
    public function movements()
    {
        return $this->belongsToMany(Movement::class)->withPivot('quantity');
    }

    /**
     * @return Collection
     */
    public function notes()
    {
        return $this->belongsToMany(Note::class)->withPivot('quantity');
    }
}
