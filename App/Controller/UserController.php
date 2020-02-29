<?php


namespace App\Controller;


use App\Http\Response;
use App\Repository\UserRepository;
use App\Service\UserService;

class UserController extends AbstractController
{

    /**
     * @Route(url="/login")
     *
     * @param UserRepository $user_repository
     * @param UserService $user_service
     * @return Response
     */
    public function login(UserRepository $user_repository, UserService $user_service)
    {
        $request = $this->getRequest();

        $email = $request->getStringFromPost('email');
        $password = $request->getStringFromPost('password');

        $user = $user_repository->findByColumnValue('email', $email);

        if (is_null($user)) {
            die('User not found or data is incorrect');
        }

        $password = $user_service->generatePasswordHash($password);
        if ($user->getPassword() !== $password) {
            die('User not found or data is incorrect');
        }

        $user_id = $user->getId();
        $session_key = $user_service->getSessionKey();
        $this->getSession()->setSessionByKey($session_key, $user_id);

        return $this->redirect($request->getRefererUrl());
    }

    /**
     * @Route(url="/register")
     *
     * @param UserRepository $user_repository
     * @param UserService $user_service
     * @return Response
     */
    public function register(UserRepository $user_repository, UserService $user_service)
    {
        $user = $user_repository->create();

        $request = $this->getRequest();
        if ($request->isPostData()) {
            $name = $request->getStringFromPost('name');
            $email = $request->getStringFromPost('email');
            $password = $request->getStringFromPost('password');
            $password_repeat = $request->getStringFromPost('password_repeat');

            if ($password !== $password_repeat) {
                die('Passwords mismatch');
            }

            $is_email_exist = $user_repository->isEmailExist($email);
            if ($is_email_exist) {
                die('email is busy');
            }

            $password = $user_service->generatePasswordHash($password);

            $user->setName($name);
            $user->setEmail($email);
            $user->setPassword($password);

            $user_repository->save($user);

            return $this->redirect('/');
        }

        return $this->render('user/register.tpl',[]);
    }


    /**
     * @Route(url="/logout")
     *
     * @param UserService $user_service
     * @return Response
     */
    public function logout(UserService $user_service)
    {
        $session_key = $user_service->getSessionKey();

        $session = $this->getSession();
        $session->unsetDataSessionByKey($session_key);

        return $this->redirect($this->getRequest()->getRefererUrl());
    }
}