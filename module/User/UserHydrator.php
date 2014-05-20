<?php
/**
 * Created by PhpStorm.
 * User: schmidtgen
 * Date: 20.05.14
 * Time: 09:31
 */

namespace Module\User;


/**
 * Class UserHydrator
 * @package Module\User
 */
class UserHydrator
{

    /**
     * Mappt Objekt auf Datenbankfelder
     * @param UserEntity $object
     * @return array
     */
    public function extract(UserEntity $object)
    {
        return array(
            'id' => $object->getId(),
            'first_name' => $object->getFirstName(),
            'last_name' => $object->getLastName(),
            'email' => $object->getEmail(),
        );
    }

    /**
     * Liest Datenbankfelder aus und
     * mappt auf Nutzerentität
     * @param array $data
     * @param UserEntity $object
     * @return UserEntity
     */
    public function hydrate(array $data, UserEntity $object)
    {
        $object->setId($data['id']);
        $object->setFirstName($data['first_name']);
        $object->setLastName($data['last_name']);
        $object->setEmail($data['email']);
        return $object;
    }
} 