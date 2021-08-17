<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'column_id',
        'title',
        'description',
    ];

    public function column()
    {
        return $this->belongsTo(Column::class);
    }

    public function getSortOrder()
    {
        $sortOrder = 1;
        if (Card::where('column_id', $this->column_id)->count() > 0) {
            $sortOrder = Card::where('column_id', $this->column_id)->max('sort_order');
            return $sortOrder + 1;
        }
        return $sortOrder;
    }
}
