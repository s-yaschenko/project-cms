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
}