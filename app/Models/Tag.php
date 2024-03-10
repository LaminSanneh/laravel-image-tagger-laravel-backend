<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $tag_title
 * @property string $x_offset
 * @property string $y_offset
 * @property int $photo_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag wherePhotoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereTagTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereXOffset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereYOffset($value)
 * @mixin \Eloquent
 */
class Tag extends Model
{
    protected $casts = [
        'x_offset' => 'decimal:8',
        'y_offset' => 'decimal:8',
    ];
    
    protected $fillable = [
        'tag_title',
        'x_offset',
        'y_offset'
    ];

    use HasFactory;
}
