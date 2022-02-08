<?php

namespace App\Controller\admin;

use App\Framework\FlashBag;
use App\Model\ArticleModel;
use App\Model\CategoryModel;
use App\Framework\AbstractController;
use App\Framework\UserSession;
use App\Model\UserModel;

class ColorAdminController extends AbstractController{

    public function __construct(){

        $this-> articleModel = new ArticleModel;
        $this ->categoryModel = new CategoryModel;
    
    }

    public function color(){
        include LIBRARY_DIR .'/adminCheck.php';

        $colors = $this -> categoryModel -> getColors();

        return $this->render('admin/color.admin',[
            'colors' => $colors
        ]);
    }

    public function addColor(){
        include LIBRARY_DIR .'/adminCheck.php';
        $colors = $this -> categoryModel -> getColors();

        if (!empty($_POST)) {
        
            $colorName = trim($_POST['colorName']);
            $this -> categoryModel ->insertColor($colorName);
        }

        return $this->render('admin/add/addColor.admin',[
            'colors'=> $colors
        ]);
    }
    public function editColor(){

        include LIBRARY_DIR .'/adminCheck.php';

        if (!array_key_exists('color_id', $_GET) || ! isset($_GET['color_id']) || !ctype_digit($_GET['color_id'])){
            http_response_code(404); // On modifie le code de status de la réponse HTTP 
            echo '404 NOT FOUND'; // On affiche un message à l'internaute
            exit; // On arrête le script PHP, on n'a plus rien à faire ! 
        }
       
        $colorId = $_GET['color_id'];
        $color = $this -> categoryModel -> getColor($colorId);

        if (!empty($_POST)) {

            $colorName = trim($_POST['colorName']);

            if (!$colorName) {
                FlashBag::addFlash('Le champ "Nom du produit" est obligatoire', 'error');
            }
            if (!FlashBag::hasMessages('error')) {
                // On enregistre les données dans la base
               $this -> categoryModel-> editColor($colorName,$colorId);
                // Message flash
                FlashBag::addFlash('Article ajouté avec succès.');
                // Redirection vers le dashboard admin
                $this->redirect('admin');
            }
        }

        return $this->render('admin/edit/editColor.admin',[
            'color' => $colorName??$color['libCouleur'],
            'colorId'=> $colorId
        ]);
    }

    public function deleteColor(){

        include LIBRARY_DIR .'/adminCheck.php';
        if (!array_key_exists('color_id', $_GET) || ! isset($_GET['color_id']) || !ctype_digit($_GET['color_id'])){
            http_response_code(404); // On modifie le code de status de la réponse HTTP 
            echo '404 NOT FOUND'; // On affiche un message à l'internaute
            exit; // On arrête le script PHP, on n'a plus rien à faire ! 
        }
        $idCol = (int)$_GET['color_id'];
        $this -> categoryModel -> deleteColor($idCol);

    }
}