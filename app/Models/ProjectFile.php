<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectFile extends Model
{
    protected $fillable = [
        'project_id',
        'uploaded_by',
        'original_name',
        'stored_path',
        'disk',
        'mime_type',
        'size_bytes',
        'description',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getHumanSizeAttribute(): string
    {
        $bytes = $this->size_bytes;
        if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576)    return number_format($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024)       return number_format($bytes / 1024, 2) . ' KB';
        return $bytes . ' B';
    }

    public function getIconClassAttribute(): string
    {
        return match (true) {
            str_contains($this->mime_type ?? '', 'pdf')   => 'fas fa-file-pdf',
            str_contains($this->mime_type ?? '', 'image') => 'fas fa-file-image',
            str_contains($this->mime_type ?? '', 'zip')   => 'fas fa-file-archive',
            str_contains($this->mime_type ?? '', 'word')  => 'fas fa-file-word',
            str_contains($this->mime_type ?? '', 'sheet') => 'fas fa-file-excel',
            default                                        => 'fas fa-file',
        };
    }
}
