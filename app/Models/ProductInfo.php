<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_import_log_id',
        'item_code',
        'project_item',
        'superseded',
        'updated_by'
    ];

    public function imageFile()
    {
        return $this->hasOne(ProductInfoFile::class, 'item_code', 'item_code')
            ->where('type', 'image');
    }

    public function catalogueFiles()
    {
        return $this->hasMany(ProductInfoFile::class, 'item_code', 'item_code')
            ->where('type', 'catalogue');
    }

    public function catalogueActiveFiles()
    {
        return $this->hasMany(ProductInfoFile::class, 'item_code', 'item_code')
            ->where('type', 'catalogue')
            ->where('is_active', true);
    }

    public function manualFiles()
    {
        return $this->hasMany(ProductInfoFile::class, 'item_code', 'item_code')
            ->where('type', 'manual');
    }

    public function manualActiveFiles()
    {
        return $this->hasMany(ProductInfoFile::class, 'item_code', 'item_code')
            ->where('type', 'manual')
            ->where('is_active', true);
    }

    public function specsheetFiles()
    {
        return $this->hasMany(ProductInfoFile::class, 'item_code', 'item_code')
            ->where('type', 'specsheet');
    }

    public function specsheetActiveFiles()
    {
        return $this->hasMany(ProductInfoFile::class, 'item_code', 'item_code')
            ->where('type', 'specsheet')
            ->where('is_active', true);
    }

    public function fileImportLog()
    {
        return $this->belongsToMany(FileImportLog::class, 'file_import_logs', 'id', 'file_import_log_id');
    }
}
