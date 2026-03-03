<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'title','reference','description',
        'service_id','uploaded_by',
        'file_path','original_name','file_size','mime_type', 'folder_id',
        'status',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function folder()
{
    return $this->belongsTo(Folder::class);
}
}