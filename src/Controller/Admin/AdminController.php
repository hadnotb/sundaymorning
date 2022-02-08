<?php

namespace App\Controller\admin;

use App\Framework\FlashBag;
use App\Model\ArticleModel;
use App\Model\CategoryModel;
use App\Model\UserModel;
use App\Framework\UserSession;
use App\Framework\AbstractController;


class AdminController extends AbstractController{

    public function __construct(){

        $this-> articleModel = new ArticleModel;
        $this ->categoryModel = new CategoryModel;
    
    }

    public function index(){
        // Protection de l'administration
        include LIBRARY_DIR .'/adminCheck.php';

        return $this->render('admin/index.admin');
    }

    public function product(){
        include LIBRARY_DIR .'/adminCheck.php';
        
        $product = $this-> articleModel -> getAllArticle();
       
        return $this->render('admin/product.admin',[
            'products' => $product
        ]);
    }
    
    

    
}