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

 /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'reviewed_by' => 'integer',
        'status' => 'string',
        'file_id' => 'integer',
        'rate_count' => 'integer',
        'comment' => 'string'
    ];

    protected $attributes = [
        'deleted' => false,
    ];

/**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'rate_count' => 'required|integer',
        'comment' => 'required|string'
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
