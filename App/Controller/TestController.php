<?php


namespace App\Controller;


use App\Http\Response;

class TestController extends AbstractController
{
    /**
     * @Route(url="/test")
     *
     * @return Response
     */
    public function index()
    {
        $h1 = 'Hello world :)';

        return $this->json([
            'h1' => $h1
        ]);

    }


    /**
     * @Route(url="/test_view")
     *
     * @return Response
     */
    public function view()
    {
        return $this->redirect('/');
    }
}