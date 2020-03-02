<?php


namespace App\Repository;


use App\Model\User;

/**
 * Class UserRepository
 * @package App\Repository
 *
 * @method User find(int $id)
 * @method User[] findAll()
 * @method User|null findByColumnValue(string $column, string $value)
 * @method User createNewEntity()
 */
class UserRepository extends AbstractRepository
{

    protected $model = User::class;

    /**
     * @param string $email
     * @return bool
     */
    public function isEmailExist(string $email)
    {
        $odm = $this->getObjectDataManager();

        $email = $odm->escape($email);
        $query = $this->getQueryBuilder()
            ->select()
            ->from('users')
            ->where('email', $email)
            ->getQuery();

        $result = $odm->fetchRow($query, $this->model);

        return !is_null($result);
    }

}