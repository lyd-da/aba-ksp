<?php

namespace App\Http\Controllers;

use App\DataTables\FileDataTable;
// use App\Document;
// use App\Http\Requests\CreateUserRequest;
// use App\Http\Requests\UpdateUserRequest;
// use App\Repositories\PermissionRepository;
// use App\Repositories\UserRepository;
// use App\Tag;
use App\File;
use Flash;
use Response;

class FileController extends AppBaseController
{
    // /** @var  UserRepository */
    // private $userRepository;

    // /** @var PermissionRepository */
    // private $permissionRepository;

    // public function __construct(UserRepository $userRepo,
    //                             PermissionRepository $permissionRepository)
    // {
    //     $this->userRepository = $userRepo;
    //     $this->permissionRepository = $permissionRepository;
    // }

    /**
     * Display a listing of the User.
     *
     * @param FileDataTable $fileDataTable
     * @return Response
     */
    public function index(FileDataTable $fileDataTable)
    {
        $this->isSuperAdmin();
        return $fileDataTable->render('documents.files.index');
    }

    

    
    

   
    


  
    

    

    
    
}
