
<?php

namespace App\Models;

use App\Traits\BelongsToTeam;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory, SoftDeletes, BelongsToTeam;

    protected $fillable = [
        'team_id',
        'uploaded_by_id',
        'mediable_type',
        'mediable_id',
        'name',
        'original_name',
        'file_name',
        'mime_type',
        'extension',
        'size',
        'disk',
        'path',
        'url',
        'width',
        'height',
        'page_count',
        'metadata',
        'description',
        'version',
        'parent_media_id',
        'is_public',
        'access_token',
        'access_token_expires_at',
        'scan_status',
        'scanned_at',
    ];

    protected $casts = [
        'size' => 'integer',
        'width' => 'integer',
        'height' => 'integer',
        'page_count' => 'integer',
        'metadata' => 'array',
        'version' => 'integer',
        'is_public' => 'boolean',
        'access_token_expires_at' => 'datetime',
        'scanned_at' => 'datetime',
    ];

    protected $appends = ['formatted_size', 'is_image'];

    // Relationships
    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by_id');
    }

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }

    public function parentMedia(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'parent_media_id');
    }

    public function versions(): HasMany
    {
        return $this->hasMany(Media::class, 'parent_media_id');
    }

    // Accessors
    public function getFormattedSizeAttribute(): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->size;
        $unit = 0;

        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return round($size, 2) . ' ' . $units[$unit];
    }

    public function getIsImageAttribute(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    public function getDownloadUrlAttribute(): string
    {
        return route('media.download', $this->id);
    }

    // Methods
    public function getTemporaryUrl(int $minutes = 60): string
    {
        return Storage::disk($this->disk)->temporaryUrl($this->path, now()->addMinutes($minutes));
    }

    public function delete(): ?bool
    {
        // Delete physical file
        if (Storage::disk($this->disk)->exists($this->path)) {
            Storage::disk($this->disk)->delete($this->path);
        }

        return parent::delete();
    }
}