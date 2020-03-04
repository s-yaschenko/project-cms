<?php


namespace App\Controller;


use App\Http\Response;
use App\Repository\VendorRepository;

class VendorController extends AbstractController
{
    /**
     * @Route(url="/vendors")
     *
     * @param VendorRepository $vendor_repository
     * @return Response
     */
    public function list(VendorRepository $vendor_repository)
    {
        $vendors = $vendor_repository->findAll();

        return $this->render('vendor/list.tpl', [
            'vendors' => $vendors
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
}