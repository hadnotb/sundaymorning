<?php 

namespace App\Controller;

use App\Framework\AbstractController;
use App\Framework\FlashBag;
use App\Framework\UserSession;
use App\Model\UserModel;


class AccountController extends AbstractController {


public function signup()
    {
        // Si le formulaire a été soumis... 
        if (!empty($_POST)) {

            
            // On récupère les données du formulaire dans des variables
            $firstname = trim($_POST['firstname']);
            $lastname = trim($_POST['lastname']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            // Instanciation de la classe UserModel
            $userModel = new UserModel();

            // Validation du formulaire : pour chaque erreur on ajoute un mesage flash
            if (!$firstname) {
                FlashBag::addFlash('Le champ "Prénom" est obligatoire','error');
            }

            if (!$lastname) {
                FlashBag::addFlash('Le champ "Nom" est obligatoire','error');
            }

            if (!$email) {
                FlashBag::addFlash('Le champ "Email" est obligatoire','error');
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                FlashBag::addFlash('Le champ "Email" n\'est pas valide','error');
            } elseif ($userModel->getUserByEmail($email)) {
                FlashBag::addFlash('Il existe déjà un compte avec cet email','error');
                
            }

            if (!$password) {
                FlashBag::addFlash('Le champ "Mot de passe" est obligatoire','error');
            } elseif (strlen($email) < 8) {
                FlashBag::addFlash('Le champ "Mot de passe" doit faire au moins 8 caractères','error');
            }

            // Si il n'y a pas d'erreur (donc pas de message flash de type 'error')
            if (!FlashBag::hasMessages('error')) {

                // Hashage du mot de passe pour le protéger en base de données
                $hash = password_hash($password, PASSWORD_DEFAULT);

                // On fait appel au UserModel pour insérer les données dans la table user
                $userId = $userModel->insertUser($firstname, $lastname, $email, $hash);
                

                $userModel->addRole($userId, UserModel::ROLE_USER);

                // On ajoute un messgae flash de succès
                FlashBag::addFlash('Compte créé avec succès, connectez-vous.');

                // On redirige l'internaute pour l'instant vers la page d'accueil
                $this->redirect('homepage');
            }
        }
        return $this->render('signup', [
            'firstname' => $firstname??'',
            'lastname' => $lastname??'',
            'email' => $email??''
        ]); 
    }

    public function accountPage()
    {
        $session = $_SESSION['user'];
       
        
        return $this->render('account',[
            'session' => $session??'',
            
        ]);
    } 
}

 