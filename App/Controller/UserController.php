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
        $redirect_url = $request->getRefererUrl();
        if ($request->isPostData()) {
            $email = $request->getStringFromPost('email');
            $password = $request->getStringFromPost('password');

            $user = $user_repository->findByColumnValue('email', $email);

            if (is_null($user)) {
                $this->getFlashMessageService()->message('danger', 'Пользователь не найден или данные неверны!');
                return $this->redirect($redirect_url);
            }

            $password = $user_service->generatePasswordHash($password);
            if ($user->getPassword() !== $password) {
                $this->getFlashMessageService()->message('danger', 'Пользователь не найден или данные неверны!');
                return $this->redirect($redirect_url);
            }

            $user_id = $user->getId();
            $session_key = $user_service->getSessionKey();
            $this->getSession()->setSessionByKey($session_key, $user_id);
            return $this->redirect('/');
        }

        return $this->render('user/login.tpl',[]);
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
        $user = $user_repository->createNewEntity();

        $request = $this->getRequest();
        $redirect_url = $request->getRefererUrl();

        if ($request->isPostData()) {
            $name = $request->getStringFromPost('name');
            $email = $request->getStringFromPost('email');
            $password = $request->getStringFromPost('password');
            $password_repeat = $request->getStringFromPost('password_repeat');

            if ($password !== $password_repeat) {
                $this->getFlashMessageService()->message('danger', 'Пароли не совпадают!');
                return $this->redirect($redirect_url);
            }

            $is_email_exist = $user_repository->isEmailExist($email);
            if ($is_email_exist) {
                $this->getFlashMessageService()->message('danger', 'Пользователь с таким Email уже существует!');
                return $this->redirect($redirect_url);
            }

            $password = $user_service->generatePasswordHash($password);

            $user->setName($name);
            $user->setEmail($email);
            $user->setPassword($password);

            $user_repository->save($user);
            $this->getFlashMessageService()->message('success', 'Вы успешно зарегестрировались!');

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