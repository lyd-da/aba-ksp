<?php

namespace App\Repositories;

use App\FileType;
use App\Repositories\BaseRepository;
use App\Status;

/**
 * Class FileTypeRepository
 * @package App\Repositories
 * @version November 12, 2019, 12:21 pm IST
*/

class StatusRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'file_id',
        'document_id',
        'status',
        'verified_by'
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
    public function changeStatus($filesData,$document)
    {
        // $status = Status:
        $document->updated_at = now();
        $document->status = config('constants.STATUS.PENDING');
        $document->save();
        foreach ($filesData as $key=>$filesDatum) {
            $filesData[$key]['document_id'] = $document->id;
        }
        $document->files()->insert($filesData);
    }
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Status::class;
    }
}
