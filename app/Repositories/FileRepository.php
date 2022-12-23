<?php


namespace App\Repositories;


use App\Document;
use App\File;
use App\FileType;
use App\User;
use Illuminate\Container\Container as Application;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;

class FileRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'status',
        
        'custom_fields'
    ];

    /** @var PermissionRepository $permissionRepository */
    private $permissionRepository;

    public function __construct(Application $app,PermissionRepository $permissionRepository)
    {
        parent::__construct($app);
        $this->permissionRepository = $permissionRepository;
    }


    /**
     * Get searchable fields array
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     *
     * @return string
     */
    public function model()
    {
        return File::class;
    }


    /**
     * Search or get all documents with pagination
     * @param null $search
     * @param array $tag
     * @param null $status
     * @param bool $paginate
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection|array
     */
    public function searchFiles($search=null,$tag=null,$status=null,$paginate=true)
    {
        $query = $this->allQuery($search);
        if(!empty($tag)){
            $query->whereHas('tags', function ($q) use ($tag) {
                $q->whereIn('tag_id', $tag);
            });
        }
        if(!empty($status)){
            $query->where('status',$status);
        }
        // $query = $query->with('tags');
        debug($query->toSql());
        if($paginate)
            return $query->paginate(25);
        else
            return $query->get();
    }

    public function createWithTags($data)
    {
        $document = $this->create($data);
        $document->tags()->attach($data['tags']);
        return $document;
    }

    public function updateWithTags($data,$document)
    {
        $document->update($data);
        $document->tags()->sync($data['tags']);
    }

    

   

    

    


}
