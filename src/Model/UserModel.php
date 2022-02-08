<?php 

namespace App\Model;

use App\Framework\AbstractModel;

class UserModel extends AbstractModel {

    const ROLE_USER = 'USER';

    const ROLE_ADMIN = 'ADMIN';

    public function insertUser(string $firstname, string $lastname, string $email, string $password)
    {
        $sql = 'INSERT INTO user (firstname, lastname, email, password, created_at)
                VALUES (?,?,?,?,NOW())';

        return $this->database->insert($sql, [$firstname, $lastname, $email, $password]);
    }

    public function addRole(int $userId, string $role)
    {
        $sql = 'INSERT INTO user_role (user_id, role_id) 
                VALUES (?, (SELECT id FROM role WHERE role_label = ?))';
     

        $this->database->insert($sql, [$userId, $role]);
    }

    public function getRoles(int $userId)
    {
        $sql = 'SELECT role_label
                FROM role AS R
                INNER JOIN user_role AS UR ON UR.role_id = R.id
                WHERE UR.user_id = ?';

        $roles = $this->database->getAllResults($sql, [$userId]);

        return array_map(function($item){
            return $item['role_label'];
        }, $roles);
    }

    public function getUserByEmail(string $email)
    {
        $sql = 'SELECT *
                FROM user
                WHERE email = ?';

        return $this->database->getOneResult($sql, [$email]);
    }

    public function checkCredentials(string $email, string $password)
    {
        // On va chercher dans la base l'utilisateur qui correspond à l'email
        $user = $this->getUserByEmail($email);

        // Si on ne trouve aucun utilisateur avec cet email => échec
        if (!$user) {
            return false;
        }

        // Ensuite si le mot de passe est inccorrect => échec
        if (!password_verify($password, $user['password'])) {
            return false;
        }

        // Si tout est ok, on retourne l'utilisateur
        return $user;
    }

}