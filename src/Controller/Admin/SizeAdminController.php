<?php

namespace App\Controller\admin;

use App\Framework\FlashBag;
use App\Model\ArticleModel;
use App\Model\CategoryModel;
use App\Framework\AbstractController;
use App\Framework\UserSession;
use App\Model\UserModel;

class SizeAdminController extends AbstractController{

    public function __construct(){

        $this-> articleModel = new ArticleModel;
        $this ->categoryModel = new CategoryModel;
    
    }

    public function size(){
        include LIBRARY_DIR .'/adminCheck.php';

        $sizes = $this -> categoryModel -> getSizes();

        return $this->render('admin/size.admin',[
            'sizes' => $sizes
        ]);
    }

   
    public function addSize(){
        include LIBRARY_DIR .'/adminCheck.php';

        $sizes = $this -> categoryModel -> getSizes();
        if(!empty($_POST)){
            $sizeName = $_POST['sizeName'];
            
            $this -> categoryModel ->insertSize($sizeName);
            return $this->redirect('admin');

        }
        return $this->render('admin/add/addSize.admin',[
            'sizes' => $sizes
        ]);
    }

    public function editSize(){
        include LIBRARY_DIR .'/adminCheck.php';
        if (!array_key_exists('size_id', $_GET) || ! isset($_GET['size_id']) || !ctype_digit($_GET['size_id'])){
            http_response_code(404); // On modifie le code de status de la réponse HTTP 
            echo '404 NOT FOUND'; // On affiche un message à l'internaute
            exit; // On arrête le script PHP, on n'a plus rien à faire ! 
        }


        $idSize = $_GET['size_id'];

        $size = $this-> categoryModel -> getSize($idSize);
        


        if (!empty($_POST)) {


            $sizeName = trim($_POST['sizeName']);

            if (!$productName) {
                FlashBag::addFlash('Le champ "Nom du produit" est obligatoire', 'error');
            }

            if (!$productPrice) {
                FlashBag::addFlash('Le champ "Prix" est obligatoire', 'error');
            }

            if (!$productDescription) {
                FlashBag::addFlash('Le champ "Description" est obligatoire', 'error');
            }
            if (!$productThumbnail) {
                FlashBag::addFlash('Le champ "Image" est obligatoire', 'error');
            }
            if (!$idCategory) {
                FlashBag::addFlash('Le champ "Categorie" est obligatoire', 'error');
            }
            if (!$idBrand) {
                FlashBag::addFlash('Le champ "Marque" est obligatoire', 'error');
            }
            if (!FlashBag::hasMessages('error')) {

                // On enregistre les données dans la base
                
               $this -> categoryModel-> editSize($sizeName,$idSize);

                // Message flash
                FlashBag::addFlash('Article ajouté avec succès.');

                // Redirection vers le dashboard admin
                $this->redirect('admin');
            }
            
        }
        return $this->render('admin/edit/editSize.admin',[
            'size' => $sizeName ?? $size['libTaille'],
            'sizeId' => $idSize
        ]);
    }
    
    public function deleteSize(){
        include LIBRARY_DIR .'/adminCheck.php';
        if (!array_key_exists('size_id', $_GET) || ! isset($_GET['size_id']) || !ctype_digit($_GET['size_id'])){
            http_response_code(404); // On modifie le code de status de la réponse HTTP 
            echo '404 NOT FOUND'; // On affiche un message à l'internaute
            exit; // On arrête le script PHP, on n'a plus rien à faire ! 
        }

        $idSz = (int)$_GET['size_id'];
        $this -> categoryModel -> deleteSize($idSz);

    }
    
}