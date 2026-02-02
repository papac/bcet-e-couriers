<?php

namespace App\Models;

use Bow\Database\Barry\Model;

/**
 * @property int $id
 * @property int $courier_id
 * @property string $filename
 * @property string $original_name
 * @property string $mime_type
 * @property int $size
 * @property string $path
 * @property int $uploaded_by
 * @property string $created_at
 * @property string $updated_at
 */
class CourierFile extends Model
{
    /**
     * The table name
     *
     * @var string
     */
    protected string $table = 'courier_files';

    /**
     * The fillable fields
     *
     * @var array
     */
    protected array $fillable = [
        'courier_id',
        'filename',
        'original_name',
        'mime_type',
        'size',
        'path',
        'uploaded_by'
    ];

    /**
     * Allowed file extensions
     */
    const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx'];

    /**
     * Allowed MIME types
     */
    const ALLOWED_MIME_TYPES = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ];

    /**
     * Maximum file size in bytes (5MB)
     */
    const MAX_FILE_SIZE = 5 * 1024 * 1024;

    /**
     * Maximum number of files per courier
     */
    const MAX_FILES_PER_COURIER = 10;

    /**
     * Get the courier that owns this file
     *
     * @return \Bow\Database\Barry\Relations\BelongsTo
     */
    public function courier()
    {
        return $this->belongsTo(Courier::class, 'courier_id');
    }

    /**
     * Get the user who uploaded this file
     *
     * @return \Bow\Database\Barry\Relations\BelongsTo
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get formatted file size
     *
     * @return string
     */
    public function getFormattedSize(): string
    {
        $bytes = $this->size;
        
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        
        return $bytes . ' bytes';
    }

    /**
     * Check if file is an image
     *
     * @return bool
     */
    public function isImage(): bool
    {
        return in_array($this->mime_type, ['image/jpeg', 'image/png', 'image/gif']);
    }

    /**
     * Check if file is a PDF
     *
     * @return bool
     */
    public function isPdf(): bool
    {
        return $this->mime_type === 'application/pdf';
    }

    /**
     * Get file icon based on MIME type
     *
     * @return string
     */
    public function getFileIcon(): string
    {
        if ($this->isImage()) {
            return 'image';
        }
        
        if ($this->isPdf()) {
            return 'pdf';
        }
        
        if (str_contains($this->mime_type, 'word')) {
            return 'word';
        }
        
        if (str_contains($this->mime_type, 'excel') || str_contains($this->mime_type, 'spreadsheet')) {
            return 'excel';
        }
        
        return 'file';
    }

    /**
     * Get the full URL to the file
     *
     * @return string
     */
    public function getUrl(): string
    {
        return '/storage/couriers/' . $this->filename;
    }

    /**
     * Validate file upload
     *
     * @param array $file
     * @return array|null Returns error array or null if valid
     */
    public static function validateFile(array $file): ?array
    {
        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['error' => 'Erreur lors du téléchargement du fichier'];
        }

        // Check file size
        if ($file['size'] > self::MAX_FILE_SIZE) {
            return ['error' => 'Le fichier est trop volumineux (max 5MB)'];
        }

        // Check MIME type
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);
        
        if (!in_array($mimeType, self::ALLOWED_MIME_TYPES)) {
            return ['error' => 'Type de fichier non autorisé'];
        }

        // Check extension
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, self::ALLOWED_EXTENSIONS)) {
            return ['error' => 'Extension de fichier non autorisée'];
        }

        return null;
    }
}
