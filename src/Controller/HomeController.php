<?php 

namespace App\Controller;
use App\Model\ArticleModel;
use App\Framework\AbstractController;

class HomeController extends AbstractController {

    public function index()
    {   
        $ArticleModel = new ArticleModel;
        $articles = $ArticleModel -> getSeveralArticle();
        // Affichage : inclusion du template
        return $this->render('home', [
            'articles' => $articles
        ]);
    }
}
