<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentArchive extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_number',
        'title',
        'document_type',
        'description',
        'file_path',
        'file_size',
        'issued_date',
        'issued_by',
        'uploaded_by',
    ];

    protected $casts = [
        'issued_date' => 'date',
    ];

    /**
     * Label tipe dokumen dalam Bahasa Indonesia.
     */
    public const DOCUMENT_TYPES = [
        'perda'            => 'Peraturan Daerah',
        'perbup'           => 'Peraturan Bupati',
        'sk'               => 'Surat Keputusan',
        'surat_perjanjian' => 'Surat Perjanjian',
        'mou'              => 'MoU',
        'lainnya'          => 'Lainnya',
    ];

    /**
     * Relasi ke user yang meng-upload dokumen.
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Mendapatkan label tipe dokumen.
     */
    public function getDocumentTypeLabelAttribute(): string
    {
        return self::DOCUMENT_TYPES[$this->document_type] ?? $this->document_type;
    }

    /**
     * Mendapatkan ukuran file yang sudah diformat (KB/MB).
     */
    public function getFormattedFileSizeAttribute(): string
    {
        $bytes = $this->file_size;

        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }

        return $bytes . ' B';
    }
}
