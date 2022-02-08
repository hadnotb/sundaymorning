<?php 

namespace App\Controller;

use App\Framework\AbstractController;

use App\Model\CategoryModel ;

class CategoryController extends AbstractController {

    public function index()
    {
        $categoryModel = new CategoryModel;
        // Recuperation des différentes partie des categories 
        $categories = $categoryModel -> getCategories();
        $brands = $categoryModel -> getBrands();
        $sizes = $categoryModel -> getSizes();
        $colors = $categoryModel ->getColors();
        $products = null;

        // Recupereration de l'id de la couleur selectionné sur la page si selectioné
        $colorId = null;
        if (array_key_exists('couleur', $_GET) && isset($_GET['couleur']) && ctype_digit($_GET['couleur'])) {
            $colorId = $_GET['couleur'];

        }
        if($colorId){
            $products = $categoryModel -> getProductbyColor($colorId);
        }

        // Recupereration de l'id de la marque selectionné sur la page si selectioné
        $brandId = null;
        if (array_key_exists('marque', $_GET) && isset($_GET['marque']) && ctype_digit($_GET['marque'])) {
            $brandId = $_GET['marque'];

        }
        if($brandId){
            $products = $categoryModel -> getProductbyBrand($brandId);
        }

        // Recupereration de l'id de la taille selectionné sur la page si selectioné
        $sizeId = null;
        if (array_key_exists('taille', $_GET) && isset($_GET['taille']) && ctype_digit($_GET['taille'])) {
            $sizeId = $_GET['taille'];
        }
        if($sizeId){
            $products = $categoryModel -> getProductbySize($sizeId);
        }

        // Recupereration de l'id de la Categorie selectionné sur la page si selectioné

        $catId = null;
        if (array_key_exists('categorie', $_GET) && isset($_GET['categorie']) && ctype_digit($_GET['categorie'])) {
            $catId = $_GET['categorie'];
        }

        if($catId){
            // $products = $categoryModel -> getProductbyCat($catId);
            $products = $categoryModel -> getProductbyCat($catId);
            
        }
        
       


        return $this-> render('category', [
            'categories' => $categories,
            'brands' => $brands,
            'sizes' => $sizes,
            'colors' => $colors,
            'products' => $products,
            // 'Products' => $brandProduct
        ]);
    }

    public function searchArticle(){
        
        $categoryModel = new CategoryModel;
        
        if(!empty($_POST['searchBar'])){
            // TODO Essayer de gerer l'espace dans une recherche
            $toSearch = htmlspecialchars(strtolower(trim($_POST['searchBar'])));
            $results = $categoryModel -> getArticlebySearch($toSearch);
            
       
        }
        if(!$results){
            http_response_code(404);
            echo "404 NOT FOUND";
            exit;
        }
        
        return $this->render('search',[
            "products" => $results
        ]);
    }
}