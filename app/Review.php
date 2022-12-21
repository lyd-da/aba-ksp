<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public $table = 'reviews';

    public $fillable = [
        'file_id',
        'reviewed_by',
        'status',
        'comment',
        'rate_count',
        'deleted',
        'deleted_by',
    ];


    protected $attributes = [
        'deleted' => false,
    ];



    // public function createdBy()
    // {
    //     return $this->belongsTo(User::class, 'created_by', 'id');
    // }

    // public function documents()
    // {
    //     return $this->belongsToMany(Document::class, 'documents_tags', 'tag_id','document_id');
    // }
}
