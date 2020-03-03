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

    /**
     * @Route(url="/folder/create")
     *
     * @param FolderRepository $folder_repository
     * @return Response
     */
    public function create(FolderRepository $folder_repository)
    {
        $folder = $folder_repository->createNewEntity();

        $request = $this->getRequest();
        if ($request->isPostData()) {
            $name = $request->getStringFromPost('name');

            $folder->setName($name);
            $folder_repository->save($folder);

            $this->getFlashMessageService()->message('success',"Категория: {$folder->getName()}, добавлена!");

            return $this->redirect('/folders');
        }

        return $this->render('folder/folder.tpl',[
           'folder' => $folder
        ]);
    }

    /**
     * @Route(url="/folder/edit/{id}")
     *
     * @param FolderRepository $folder_repository
     * @return Response
     */
    public function edit(FolderRepository $folder_repository)
    {
        $folder_id = $this->getRoute()->getParam('id');

        $folder = $folder_repository->find($folder_id);
        if (is_null($folder)) {
            $this->getFlashMessageService()->message('info', 'Категория для редактирования не найдена!');
            return $this->redirect('/folders');
        }

        $old_name = $folder->getName();

        $request = $this->getRequest();
        if ($request->isPostData()) {
            $name = $request->getStringFromPost('name');

            $folder->setName($name);
            $folder_repository->save($folder);

            $this->getFlashMessageService()->message('success', "Название категории {$old_name} изменили на {$name}");

            return $this->redirect('/folders');
        }

        return $this->render('folder/folder.tpl', [
            'folder' => $folder
        ]);
    }
}