<?php 

namespace App\Framework;

class UserSession {

    static private function sessionCheck(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Enregistre les informations de l'utilisateur en session
     */
    static function register(int $userId, string $firstname, string $lastname, string $email, array $roles)
    {
        self::sessionCheck();

        // Enregistrement des données de l'utilisateur en session à la clé 'user'
        $_SESSION['user'] = [
            'idUser' => $userId,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'roles' => $roles
        ];
    }

    static function hasRoles()
    {
        // Si l'utilisateur n'est pas connecté on retourne false
        if (!self::isAuthenticated()){
            return false;
        }

        /*
        // On récupère les paramètres de la fonction grâce à func_get_args()
        $roles = func_get_args();

        // Pour chaque rôle donné en paramètre... 
        foreach ($roles as $role) {

            // Si le rôle est présent dans le tableau de rôles enregistrés en session... 
            if (in_array($role, $_SESSION['user']['roles'])) {

                // On retourne true
                return true;
            }
        }

        // Si on arrive ici c'est qu'on n'a trouvé aucun des rôles en session, on retourne false
        return false;
        */

        // Autre version en utilisant la fonction array_intersect()
        return array_intersect(func_get_args(), $_SESSION['user']['roles']);
    }

    static function isAuthenticated()
    {
        self::sessionCheck();
        return array_key_exists('user', $_SESSION) && isset($_SESSION['user']);
    }
    static function isAdmin()
    {
        self::sessionCheck();
        
        return array_key_exists('admin', $_SESSION) && isset($_SESSION['admin']);
    }

    static function logout()
    {
        if (!self::isAuthenticated()){
            return;
        }
        $_SESSION['user'] = null;
        session_destroy();
    }

    static function getId()
    {
        if (!self::isAuthenticated()){
            return null;
        }
        return $_SESSION['user']['userId'];
    }

    static function getFirstname()
    {
        if (!self::isAuthenticated()){
            return null;
        }
        return $_SESSION['user']['firstname'];
    }

    static function getLastname()
    {
        if (!self::isAuthenticated()){
            return null;
        }
        return $_SESSION['user']['lastname'];
    }

    static function getEmail()
    {
        if (!self::isAuthenticated()){
            return null;
        }
        return $_SESSION['user']['email'];
    }
}