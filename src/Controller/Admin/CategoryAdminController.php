<?php

namespace App\Controller\admin;

use App\Framework\FlashBag;
use App\Model\ArticleModel;
use App\Model\CategoryModel;
use App\Framework\AbstractController;
use App\Framework\UserSession;
use App\Model\UserModel;

class CategoryAdminController extends AbstractController{

    public function __construct(){

        $this-> articleModel = new ArticleModel;
        $this ->categoryModel = new CategoryModel;
    
    }

    public function category(){
        include LIBRARY_DIR .'/adminCheck.php';

        $categories = $this -> categoryModel -> getCategories();

        return $this->render('admin/category.admin',[
            'categories' => $categories
        ]);
    }

    public function sizeControl(){
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


    public function addCategory(){
        include LIBRARY_DIR .'/adminCheck.php';

        $categories = $this -> categoryModel -> getCategories();
    
        if (!empty($_POST)) {

            $categoryName = trim($_POST['categoryName']);

            if (!$categoryName) {
                FlashBag::addFlash('Le champ "Nom du produit" est obligatoire', 'error');
            }

            if (!FlashBag::hasMessages('error')) {

                // On enregistre les données dans la base
                
               $this -> categoryModel-> insertCategory($categoryName);

                // Message flash
                FlashBag::addFlash('Article ajouté avec succès.');

                // Redirection vers le dashboard admin
                $this->redirect('admin');
            }
            
        }
        return $this->render('admin/add/addCategory.admin',[
            'cats' => $categories
        ]);
    }

    public function editCategory(){
        include LIBRARY_DIR .'/adminCheck.php';

        if (!array_key_exists('category_id', $_GET) || ! isset($_GET['category_id']) || !ctype_digit($_GET['category_id'])){
            http_response_code(404); // On modifie le code de status de la réponse HTTP 
            echo '404 NOT FOUND'; // On affiche un message à l'internaute
            exit; // On arrête le script PHP, on n'a plus rien à faire ! 
        }

        $idCat = $_GET['category_id'];
        $cat = $this-> categoryModel -> getCategory($idCat);


        if (!empty($_POST)) {


            $categoryName = trim($_POST['categoryName']);

            if (!$categoryName) {
                FlashBag::addFlash('Le champ "Nom du produit" est obligatoire', 'error');
            }

            if (!FlashBag::hasMessages('error')) {

                // On enregistre les données dans la base
                
               $this -> categoryModel-> editCategory($categoryName,$idCat);

                // Message flash
                FlashBag::addFlash('Article ajouté avec succès.');

                // Redirection vers le dashboard admin
                $this->redirect('admin');
            }
        }

        return $this->render('admin/edit/editCategory.admin',[
            'cat' => $cat,
            'categoryId' => $idCat
        ]);
    }

    public function deleteCategory(){
        include LIBRARY_DIR .'/adminCheck.php';
        if (!array_key_exists('category_id', $_GET) || ! isset($_GET['category_id']) || !ctype_digit($_GET['category_id'])){
            http_response_code(404); // On modifie le code de status de la réponse HTTP 
            echo '404 NOT FOUND'; // On affiche un message à l'internaute
            exit; // On arrête le script PHP, on n'a plus rien à faire ! 
        }
        
        $idCat = (int)$_GET['category_id'];
        $this -> categoryModel -> deleteCategory($idCat);

    }
    

    
}