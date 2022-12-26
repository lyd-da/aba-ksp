<?php

namespace App\Repositories;

use App\FileType;
use App\Repositories\BaseRepository;
use App\Review;

/**
 * Class FileTypeRepository
 * @package App\Repositories
 * @version November 12, 2019, 12:21 pm IST
*/

class ReviewRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'rate_count',
        'comment'
    ];


    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Review::class;
    }
    public function query($file_id)
    {
        // ddd($this->model->newQuery()->where('file_id','=',$file_id));

        return Review::where('file_id','=',$file_id)->get();
    }
}
