<?php 

namespace App\Controller;

use App\Framework\AbstractController;

class LoginController extends AbstractController {

    public function index()
    {
        // Affichage : inclusion du template
        return $this->render('login', [
            'message' => 'login'
        ]);
    }
}