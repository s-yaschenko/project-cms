<?php


namespace App\Service;


use App\Http\Session;
use App\Model\User;
use App\Repository\UserRepository;

class UserService
{

    /**
     * @var User
     */
    private $user;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var string
     */
    private static $salt = 'Fd@6k+7+FmhO';

    /**
     * @var string
     */
    private $session_key = 'user_id';

    /**
     * @var UserRepository
     */
    private $user_repository;

    public function __construct(UserRepository $user_repository, Session $session)
    {
        $this->user_repository = $user_repository;
        $this->session = $session;
    }

    /**
     * @param string $password
     * @return string
     */
    public function generatePasswordHash(string $password)
    {
        return $this->md5($this->md5($password));
    }

    /**
     * @return string
     */
    public function getSessionKey(): string
    {
        return $this->session_key;
    }

    /**
     * @param string $string
     * @return string
     */
    private function md5(string $string)
    {
        return md5($string . static::$salt);
    }

    /**
     * @return User
     */
    public function getCurrentUser()
    {
        $key = $this->getSessionKey();
        $session = $this->getSession();

        $user_id = $session->getDataSessionByKey($key) ?? null;

        if (!is_null($user_id)) {
            $this->setUser($this->getUserRepository()->find($user_id));
        } else {
            $this->setUser(new User());
        }

        return $this->getUser();
    }

    /**
     * @return Session
     */
    private function getSession(): Session
    {
        return $this->session;
    }

    /**
     * @return User
     */
    private function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    private function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return UserRepository
     */
    private function getUserRepository(): UserRepository
    {
        return $this->user_repository;
    }
}