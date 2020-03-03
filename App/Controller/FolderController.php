<?php


namespace App\Controller;


use App\Http\Response;
use App\Repository\FolderRepository;

class FolderController extends AbstractController
{


    /**
     * @Route(url="/folders")
     *
     * @param FolderRepository $folder_repository
     * @return Response
     */
    public function list(FolderRepository $folder_repository)
    {
        $folders = $folder_repository->findAll();

        return $this->render('folder/list.tpl',[
            'folders' => $folders
        ]);
    }
}