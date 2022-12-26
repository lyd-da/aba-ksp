<?php

namespace App\Http\Controllers;

use App\DataTables\FileTypeDataTable;
use App\Http\Requests\CreateReviewRequest;
use App\Http\Requests\UpdateFileTypeRequest;
// use Flash;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ReviewRepository;
use App\Review;
use Response;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;


class ReviewController extends AppBaseController
{
    /** @var  ReviewRepository */
    private $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    // /**
    //  * Display a listing of the FileType.
    //  *
    //  * @param FileTypeDataTable $fileTypeDataTable
    //  * @return Response
    //  */
    // public function index(FileTypeDataTable $fileTypeDataTable)
    // {
    //     $this->isSuperAdmin();
    //     return $fileTypeDataTable->render('file_types.index');
    // }

    // /**
    //  * Show the form for creating a new FileType.
    //  *
    //  * @return Response
    //  */
    // public function create()
    // { 
    //     $this->isSuperAdmin();
    //     return view('file_types.create');
    // }

    /**
     * Store a newly created FileType in storage.
     *
     * @param CreateFileTypeRequest $request
     *
     * @return Response
     */

   

    public function store(CreateReviewRequest $request)
    {
        $this->isSuperAdmin();
        $input = $request->all();
        // $input['file_id'] = $input['file_id'];
        $input['reviewed_by'] = Auth::id();
        $input['status'] = config('constants.STATUS.PENDING');
        $input['deleted'] = false;
        // $file_id =(int)$input['file_id'];
        // print_r($input);

    //    $review = $this->reviewRepository->query($file_id);
       // $review = $this->reviewRepository->find($file_id);
       
       $review = $this->reviewRepository->create($input);
    //    if (empty($review)) {
    //        ddd("1");
    //     } else {

    //         $review = $this->reviewRepository->update($request->all(), $review->id);
    //        ddd("2");

    //     }



        Flash::success('File reviewed successfully.');
        return redirect()->back();
    }

    /**
     * Display the specified FileType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $this->isSuperAdmin();
        $fileType = $this->fileTypeRepository->find($id);

        if (empty($fileType)) {
            Flash::error('File Type not found');

            return redirect(route('fileTypes.index'));
        }

        return view('file_types.show')->with('fileType', $fileType);
    }

    /**
     * Show the form for editing the specified FileType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $this->isSuperAdmin();
        $fileType = $this->fileTypeRepository->find($id);

        if (empty($fileType)) {
            Flash::error('File Type not found');

            return redirect(route('fileTypes.index'));
        }

        return view('file_types.edit')->with('fileType', $fileType);
    }

    /**
     * Update the specified FileType in storage.
     *
     * @param  int              $id
     * @param UpdateFileTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFileTypeRequest $request)
    {
        $this->isSuperAdmin();
        $fileType = $this->fileTypeRepository->find($id);

        if (empty($fileType)) {
            Flash::error('File Type not found');

            return redirect(route('fileTypes.index'));
        }

        $fileType = $this->fileTypeRepository->update($request->all(), $id);

        Flash::success('File Type updated successfully.');

        return redirect(route('fileTypes.index'));
    }

    /**
     * Remove the specified FileType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->isSuperAdmin();
        $fileType = $this->fileTypeRepository->find($id);

        if (empty($fileType)) {
            Flash::error('File Type not found');

            return redirect(route('fileTypes.index'));
        }

        $this->fileTypeRepository->delete($id);

        Flash::success('File Type deleted successfully.');

        return redirect(route('fileTypes.index'));
    }
}
