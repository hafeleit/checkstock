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

    public function catalogueFiles()
    {
        return $this->hasMany(ProductInfoFile::class, 'item_code', 'item_code')
            ->where('type', 'catalogue');
    }

    public function manualFiles()
    {
        return $this->hasMany(ProductInfoFile::class, 'item_code', 'item_code')
            ->where('type', 'manual');
    }

    public function specsheetFiles()
    {
        return $this->hasMany(ProductInfoFile::class, 'item_code', 'item_code')
            ->where('type', 'specsheet');
    }

    public function fileImportLog()
    {
        return $this->belongsToMany(FileImportLog::class);
    }
}
