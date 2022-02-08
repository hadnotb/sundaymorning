<?php 

namespace App\Controller;

use App\Framework\AbstractController;
use App\Model\UserModel;
use App\Framework\UserSession;
use App\Framework\FlashBag;

class AuthController extends AbstractController {

    public function login()
    {
        if (!empty($_POST)) {
            
            // On récupère les données du formulaire de connexion, email et password
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            
            // On crée un objet UserModel pour appeler la méthode checkCredentials() qui va vérifier les identifiants
            $userModel = new UserModel();
            $user = $userModel->checkCredentials($email, $password);
            
        
            // Aucun utilisateur n'a été trouvé avec ces identifiants
            if (!$user) {
                FlashBag::addFlash('Identifiants incorrects', 'error');
            }
            // On a bien récupéré l'utilisateur, les identifiants sont corrects
            else {

                // On va chercher les rôles associés à l'utilisateur
                $roles = $userModel->getRoles($user['idUser']);
        
                // Enregistre le user en session
                UserSession::register($user['idUser'], $user['firstname'], $user['lastname'], $user['email'], $roles);
                
        
                // Message flash de succès
                FlashBag::addFlash('Connexion réussie','success');
                
                // Redirection
                $this->redirect('admin');
                
            }
        }
        
        // Affichage
        $msgErr = implode(', ', FlashBag::fetchMessages('error'));
        return $this->render('login', array('msgErr' => $msgErr));
    }

    public function logout()
    {
        // Déconnexion
        UserSession::logout();

        // Redirection vers l'accueil
        $this->redirect('homepage');
    }
}