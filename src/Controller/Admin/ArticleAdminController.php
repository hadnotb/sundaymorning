<?php

namespace App\Controller\admin;

use App\Framework\FlashBag;
use App\Model\ArticleModel;
use App\Model\CategoryModel;
use App\Framework\AbstractController;

use App\Framework\UserSession;
use App\Model\UserModel;


class ArticleAdminController extends AbstractController{

    public function __construct(){

        $this-> articleModel = new ArticleModel;
        $this ->categoryModel = new CategoryModel;
    
    }

    public function article(){
        include LIBRARY_DIR .'/adminCheck.php';

        $articles = $this -> articleModel -> getAllArticle();
        
        return $this->render('admin/article.admin',[
            'articles' => $articles
        ]);
    }
    public function addArticle(){
        include LIBRARY_DIR .'/adminCheck.php';
        
        if (!empty($_POST)) {

            // $articleColor = trim($_POST['articleModel']);
            // $articleModel = trim($_POST['articleColor']);
            // $articleSize = trim($_POST['articleSize']);
            $idArticle = intval($_POST['articleModel']);
            $idColor = intval($_POST['articleColor']);
            $idSize = intval($_POST['articleSize']);
            $nbEle = intval($_POST['articleNombre']);
            
            

            if (!FlashBag::hasMessages('error')) {

                // On enregistre les données dans la base
                $this -> articleModel-> insertArticle($idArticle,$idColor,$idSize,$nbEle);

                // Message flash
                FlashBag::addFlash('Article ajouté avec succès.');

                // Redirection vers le dashboard admin
                $this->redirect('admin');
            }
            
        }
        $models = $this-> categoryModel ->getModels();
        $colors = $this-> categoryModel ->getColors();
        $sizes = $this-> categoryModel ->getSizes();


        
        return $this->render('admin/add/addArticle.admin',[
            'models' => $models,
            'colors' => $colors,
            'sizes' => $sizes
            
            // 'allInfo' => $allInfo


        ]);
    }
    public function editArticle(){
        include LIBRARY_DIR .'/adminCheck.php';

        if (!array_key_exists('article_id', $_GET) || ! isset($_GET['article_id']) || !ctype_digit($_GET['article_id'])){
            http_response_code(404); // On modifie le code de status de la réponse HTTP 
            echo '404 NOT FOUND'; // On affiche un message à l'internaute
            exit; // On arrête le script PHP, on n'a plus rien à faire ! 
        }

        $idArticle = (int) $_GET['article_id'];
        $models = $this->categoryModel->getModels();
        $sizes = $this->categoryModel->getSizes();
        $colors = $this->categoryModel ->getColors();
        $article = $this->articleModel ->getOneArticle($idArticle);
        

        if (!empty($_POST)) {

            $articleModelId = intval($_POST['articleModel'] );
            $articleColorId = intval($_POST['articleColor'] );
            $articleSizeId = intval($_POST['articleSize'] );
            $articleNumber = intval($_POST['articleNombre']);
            dd($articleNumber);

            if (!$articleNumber) {
                FlashBag::addFlash('Le Champ nombre d\'artcile est obligatoire', 'error');
            }
            if (!FlashBag::hasMessages('error')) {

                $this -> articleModel-> editArticle($articleModelId,$articleColorId,$articleSizeId,$articleNumber,$idArticle);
                // Message flash
                FlashBag::addFlash('Article ajouté avec succès.');

                $this->redirect('admin');
            }
      
        }
        

        return $this->render('admin/edit/editArticle.admin',[
            'models' =>  $models,
            'colors' => $colors,
            'sizes' => $sizes,
            'articleNumber' => $articleNumber ?? $article['nbEle'],
            'articleSizeId' => $articleSizeId ?? $article['idTaille'],
            'articleColorId' => $articleColorId ?? $article['idCouleur'],
            'articleModelId' => $articleModelId ?? $article['idModel'],
            'idArticle' => $idArticle ?? $article['idArticle']
        ]);
    }

    public function deleteArticle(){
        include LIBRARY_DIR .'/adminCheck.php';
        if (!array_key_exists('article_id', $_GET) || ! isset($_GET['article_id']) || !ctype_digit($_GET['article_id'])){
            http_response_code(404); // On modifie le code de status de la réponse HTTP 
            echo '404 NOT FOUND'; // On affiche un message à l'internaute
            exit; // On arrête le script PHP, on n'a plus rien à faire ! 
        }

        $idArticle = (int)$_GET['article_id'];
        $this -> articleModel -> deleteArticle($idArticle);

    }
    
    
}