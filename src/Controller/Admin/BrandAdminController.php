<?php

namespace App\Controller\admin;

use App\Framework\FlashBag;
use App\Model\ArticleModel;
use App\Model\CategoryModel;
use App\Framework\AbstractController;
use App\Framework\UserSession;
use App\Model\UserModel;

class BrandAdminController extends AbstractController{

    public function __construct(){

        $this-> articleModel = new ArticleModel;
        $this ->categoryModel = new CategoryModel;
    
    }

    public function brand(){

        include LIBRARY_DIR .'/adminCheck.php';

        $brands = $this -> categoryModel -> getBrands();

        return $this->render('admin/brand.admin',[
            'brands' => $brands
        ]);
    }
    public function addBrand(){
        
        include LIBRARY_DIR .'/adminCheck.php';
        $brands = $this -> categoryModel -> getBrands();

        if (!empty($_POST)) {

            
            $brandName = trim($_POST['brandName']);
            
            
            

            if (!$brandName) {
                FlashBag::addFlash('Le champ "Nom du produit" est obligatoire', 'error');
            }

            if (!FlashBag::hasMessages('error')) {

                // On enregistre les données dans la base
                
                $this -> categoryModel-> insertBrand($brandName);

                // Message flash
                FlashBag::addFlash('Article ajouté avec succès.');

                // Redirection vers le dashboard admin
                $this->redirect('admin');

            }
            
        }

        return $this->render('admin/add/addBrand.admin',[
            'brands' => $brands
        ]);
       
    }
    public function editBrand(){
        include LIBRARY_DIR .'/adminCheck.php';

        if (!array_key_exists('brand_id', $_GET) || ! isset($_GET['brand_id']) || !ctype_digit($_GET['brand_id'])){
            http_response_code(404); // On modifie le code de status de la réponse HTTP 
            echo '404 NOT FOUND'; // On affiche un message à l'internaute
            exit; // On arrête le script PHP, on n'a plus rien à faire ! 
        }

       
        $idBrand = $_GET['brand_id'];
        $brand = $this -> categoryModel -> getBrand($idBrand);
        

        if (!empty($_POST)) {

            $brandName = trim($_POST['brandName']);
         
            if (!$brandName) {
                FlashBag::addFlash('Le champ "Nom de la marque" est obligatoire', 'error');
            }

            if (!FlashBag::hasMessages('error')) {

                // On enregistre les données dans la base
                
                $this -> categoryModel-> editBrand($brandName,$idBrand);

                // Message flash
                FlashBag::addFlash('Article ajouté avec succès.');

                // Redirection vers le dashboard admin
                $this->redirect('admin');
            }
        }

        return $this->render('admin/edit/editBrand.admin',[
            'brandId' => $idBrand,
            'brand' => $brandName ?? $brand['libMarque']

        ]);
    }
    public function deleteBrand(){
        include LIBRARY_DIR .'/adminCheck.php';
        if (!array_key_exists('brand_id', $_GET) || ! isset($_GET['brand_id']) || !ctype_digit($_GET['brand_id'])){
            http_response_code(404); // On modifie le code de status de la réponse HTTP 
            echo '404 NOT FOUND'; // On affiche un message à l'internaute
            exit; // On arrête le script PHP, on n'a plus rien à faire ! 
        }

        $idBrand = (int)$_GET['brand_id'];
        $this -> categoryModel -> deleteBrand($idBrand);

    }
}