<?php

namespace App\Models\Archive;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Archive extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'archived_id', //Model ID 
        'archive_type', //Model
        'user_id', //User who
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'archives';
}
