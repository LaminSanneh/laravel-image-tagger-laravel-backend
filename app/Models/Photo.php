<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use function url;

/**
 *
 *
 * @property int $id
 * @property string $photo_title
 * @property-read string $photo_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Photo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo wherePhotoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo wherePhotoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo_title',
        'photo_url'
    ];

    public $appends = [
        'photo_url'
    ];

    protected function photoUrl(): Attribute {
        return Attribute::make(get: fn () => url("/storage/{$this->attributes['photo_url']}"));
    }

    public function tags(): HasMany {
        return $this->hasMany(Tag::class);
    }
}
