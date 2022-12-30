<?php

namespace App\Http\Controllers;

use App\CustomField;
use App\Document;
use App\File;
use App\FileType;
use App\Http\Requests\CreateDocumentRequest;
use App\Http\Requests\CreateFilesRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Repositories\CustomFieldRepository;
use App\Repositories\DocumentRepository;
use App\Repositories\FileRepository;
use App\Repositories\FileTypeRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\TagRepository;
use App\Tag;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Laracasts\Flash\Flash;
use Spatie\Permission\Models\Permission;

class FileController extends Controller
{
    /** @var  TagRepository */
    private $tagRepository;

    /** @var DocumentRepository */
    private $documentRepository;
    /** @var FileRepository */
    private $fileRepository;

    /** @var CustomFieldRepository */
    private $customFieldRepository;

    /** @var FileTypeRepository */
    private $fileTypeRepository;

    /** @var PermissionRepository $permissionRepository */
    private $permissionRepository;

    public function __construct(
        TagRepository $tagRepository,
        FileRepository $fileRepository,
        DocumentRepository $documentRepository,
        CustomFieldRepository $customFieldRepository,
        FileTypeRepository $fileTypeRepository,
        PermissionRepository $permissionRepository
        // ,
        // FileRepository $fileRepository
        
    ) {
        $this->tagRepository = $tagRepository;
        $this->documentRepository = $documentRepository;
        $this->customFieldRepository = $customFieldRepository;
        $this->fileTypeRepository = $fileTypeRepository;
        $this->permissionRepository = $permissionRepository;
        $this->fileRepository = $fileRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $this->authorize('viewAny', File::class);
        $files = File::where('name', 'like', '%' . $request->get('search') . '%')->get();
            //   echo '<pre>'; print_r($files); echo '</pre>';

        // $files = $this->fileRepository->searchFiles(
        //     $request->get('search'),
        //     // $request->get('tags'),
        //     $request->get('status')
        // );
        // // $files = $this->fileRepository->searchFiles(
        // //     $request->get('search'),
           
        // //     $request->get('status')
        // // );
        // $tags = $this->tagRepository->all();
        // ddd('dsalkfjkl');
        return view('files.index')->with('files', $files);
    }

    public function search($docId,Request $request){
        // Get the search value from the request
        $search = $request->input('search');
        $status = $request->input('status');
        // ddd($status);
    
        // Search in the title and body columns from the posts table
        // $files = File::query()->where('document_id',$docId)
        //     ->where('name', 'LIKE', "%{$search}%" )
            
        //     ->get();
        if(!empty($status) && $status != '0'){

            $files = File::query()->where('document_id',$docId)
                ->where('status', 'LIKE', "%{$status}%" )->orWhere('status', $status)
                
                ->get();
        } else {
            $files = File::query()->where('document_id',$docId)
            ->where('name', 'LIKE', "%{$search}%" )
            
            ->get();
        }
        $document = $this->documentRepository
            ->getOneEagerLoaded($docId, ['files', 'files.fileType', 'files.createdBy', 'activities', 'activities.createdBy', 'tags']);
        if (empty($document)) {
            abort(404);
        }
        $missigDocMsgs = $this->documentRepository->buildMissingDocErrors($document);
        $dataToRet = compact('document', 'missigDocMsgs');

        // if (auth()->user()->can('user manage permission')) {
            if(true){
            $users = User::where('id', '!=', 1)->get();
      

            $thisDocPermissionUsers = $this->permissionRepository->getUsersWiseDocumentLevelPermissionsForDoc($document);
            //Tag Level permission
            $tagWisePermList = $this->permissionRepository->getTagWiseUsersPermissionsForDoc($document);
            //Global Permission
            $globalPermissionUsers = $this->permissionRepository->getGlobalPermissionsForDoc($document);

            $dataToRet = array_merge($dataToRet, compact('users', 'thisDocPermissionUsers', 'tagWisePermList', 'globalPermissionUsers'));
        }
        // Return the search view with the resluts compacted
        return view('documents.showTable', compact('files','document', 'missigDocMsgs','users', 'thisDocPermissionUsers', 'tagWisePermList', 'globalPermissionUsers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDocumentRequest $request)
    {
        $data = $request->all();
        $data['created_by'] = Auth::id();
        $data['status'] = config('constants.STATUS.PENDING');

        $this->authorize('store', [Document::class, $data['tags']]);

        $document = $this->documentRepository->createWithTags($data);
        Flash::success(ucfirst(config('settings.document_label_singular')) . " Saved Successfully");
        $document->newActivity(ucfirst(config('settings.document_label_singular')) . " Created");

        //create permission for new document
        foreach (config('constants.DOCUMENT_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $document->id]);
        }

        if ($request->has('savnup')) {
            return redirect()->route('documents.files.create', $document->id);
        }
        return redirect()->route('documents.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /** @var Document $document */
        $document = $this->documentRepository
            ->getOneEagerLoaded($id, ['files', 'files.fileType', 'files.createdBy', 'activities', 'activities.createdBy', 'tags']);
        if (empty($document)) {
            abort(404);
        }
        $this->authorize('view', $document);

        $missigDocMsgs = $this->documentRepository->buildMissingDocErrors($document);
        $dataToRet = compact('document', 'missigDocMsgs');

        if (auth()->user()->can('user manage permission')) {
            $users = User::where('id', '!=', 1)->get();
            $thisDocPermissionUsers = $this->permissionRepository->getUsersWiseDocumentLevelPermissionsForDoc($document);
            //Tag Level permission
            $tagWisePermList = $this->permissionRepository->getTagWiseUsersPermissionsForDoc($document);
            //Global Permission
            $globalPermissionUsers = $this->permissionRepository->getGlobalPermissionsForDoc($document);

            $dataToRet = array_merge($dataToRet, compact('users', 'thisDocPermissionUsers', 'tagWisePermList', 'globalPermissionUsers'));
        }
        // $files = $this->fileRepository->searchFiles(
        //     $request->get('search'),
        //     $request->get('tags'),
        //     $request->get('status')
        // );
        // $tags = $this->tagRepository->all();
        return view('documents.show', $dataToRet);
    }

    public function storePermission($id, Request $request)
    {
        abort_if(!auth()->user()->can('user manage permission'), 403, 'This action is unauthorized .');
        $input = $request->all();
        $user = User::findOrFail($input['user_id']);
        $doc_permissions = $input['document_permissions'];
        $document = Document::findOrFail($id);
        $this->permissionRepository->setDocumentLevelPermissionForUser($user, $document, $doc_permissions);
        Flash::success(ucfirst(config('settings.document_label_singular')) . " Permission allocated");
        return redirect()->back();
    }
}
