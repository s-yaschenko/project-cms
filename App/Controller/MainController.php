<?php


namespace App\Controller;


use App\Http\Response;

class MainController extends AbstractController
{

    /**
     * @Route(url="/")
     *
     * @return Response
     */
    public function index()
    {
        $h1 = 'Hello world :)';

        return $this->render('index.tpl',[
            'h1' => $h1
        ]);

    }


    /**
     * @Route(url="/view")
     *
     * @return Response
     */
    public function view()
    {
        $id = $this->getRoute()->getParam('id');
        $h1 = 'Hello world :( ' . $id;

        return $this->render('view.tpl',[
            'h1' => $h1
        ]);
    }
}