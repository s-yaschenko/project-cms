<?php


namespace App\Controller;


use App\Http\Response;
use App\Repository\VendorRepository;
use App\Service\PaginationService;

class VendorController extends AbstractController
{

    private const PER_PAGE = 10;

    /**
     * @Route(url="/vendors")
     *
     * @param VendorRepository $vendor_repository
     * @return Response
     */
    public function list(VendorRepository $vendor_repository, PaginationService $pagination)
    {
        $vendors = $pagination->paginate($vendor_repository, $this->getRequest(), self::PER_PAGE);

        $paginator = [
            'pages' => $pagination->pages($vendors),
            'current' => $pagination->currentPage($vendors)
        ];

        return $this->render('vendor/list.tpl', [
            'vendors' => $vendors,
            'paginator' => $paginator
        ]);
    }

    /**
     * @Route(url="/vendor/create")
     *
     * @param VendorRepository $vendor_repository
     * @return Response
     */
    public function create(VendorRepository $vendor_repository)
    {
        $vendor = $vendor_repository->createNewEntity();

        $request = $this->getRequest();
        if ($request->isPostData()) {
            $name = $request->getStringFromPost('name');

            $vendor->setName($name);
            $vendor_repository->save($vendor);

            $this->getFlashMessageService()->message('success',"Производитель: '{$vendor->getName()}' добавлен!");

            return $this->redirect('/vendors');
        }

        return $this->render('vendor/vendor.tpl',[
            'vendor' => $vendor
        ]);
    }

    /**
     * @Route(url="/vendor/edit/{id}")
     *
     * @param VendorRepository $vendor_repository
     * @return Response
     */
    public function edit(VendorRepository $vendor_repository)
    {
        $vendor_id = $this->getRoute()->getParam('id');

        $vendor = $vendor_repository->find($vendor_id);
        if (is_null($vendor)) {
            $this->getFlashMessageService()->message('info', 'Категория для редактирования не найдена!');
            return $this->redirect('/folders');
        }

        $old_name = $vendor->getName();

        $request = $this->getRequest();
        if ($request->isPostData()) {
            $name = $request->getStringFromPost('name');

            $vendor->setName($name);
            $vendor_repository->save($vendor);

            $this->getFlashMessageService()->message('success', "Название категории '{$old_name}' изменили на '{$name}'");

            return $this->redirect('/vendors');
        }

        return $this->render('vendor/vendor.tpl', [
            'vendor' => $vendor
        ]);
    }

    /**
     * @Route(url="/vendor/delete")
     *
     * @param VendorRepository $vendor_repository
     * @return Response
     */
    public function delete(VendorRepository $vendor_repository)
    {
        $request = $this->getRequest();

        $vendor_id = $request->getIntFromPost('id');

        $vendor = $vendor_repository->find($vendor_id);
        if (is_null($vendor)) {
            $this->getFlashMessageService()->message('info', 'Производитель для удаления не найден!');
            $this->redirect('/vendors');
        }

        $vendor_repository->delete($vendor);

        $this->getFlashMessageService()->message('success', "Производитель '{$vendor->getName()}' удален!");

        return $this->redirect('/vendors');
    }
}