<?php

namespace App\Controller\admin;

use PDO;
use App\Model\UserModel;
use App\Framework\FlashBag;
use App\Model\ArticleModel;
use App\Model\CategoryModel;
use App\Framework\UserSession;
use App\Framework\AbstractController;

class ModelAdminController extends AbstractController{

    public function __construct(){

        $this-> articleModel = new ArticleModel;
        $this ->categoryModel = new CategoryModel;
        
    }

    public function model(){
        include LIBRARY_DIR .'/adminCheck.php';

        $models = $this-> articleModel -> getAllModel();
       
        return $this->render('admin/model.admin',[
            'models' => $models
        ]);
    }

    public function addModel(){
        include LIBRARY_DIR .'/adminCheck.php';
        
        if (!empty($_POST)) {

            // Je recuper les donnée du formulaire d'ajout de model

            $productName = trim($_POST['productName']);
            $productPrice = trim($_POST['productPrice']);
            $productDescription = trim($_POST['productDescription']);
            $idCategory = intval($_POST['productCategory']);
            $idBrand = intval($_POST['productBrand']);

            // Je recupere le nom du fichier stcoké dans le serveur temporaire 
            $img=trim($_FILES['productThumbnail']['name']);

            // Verification de (+message flash): Si le nom du model est inséré
            if (!$productName) {
                FlashBag::addFlash('Le champ "Nom du produit" est obligatoire', 'error');
            }

            // Si le prix du model est inséré
            if (!$productPrice) {
                FlashBag::addFlash('Le champ "Prix" est obligatoire', 'error');
            }
            // Si la description du produit est inséré
            if (!$productDescription) {
                FlashBag::addFlash('Le champ "Description" est obligatoire', 'error');
            }
            // Si l'image du model est inséré
            if (!$img) {
                FlashBag::addFlash('Le champ "Image" est obligatoire', 'error');
            }
            // Si la categorie est inséré
            if (!$idCategory) {
                FlashBag::addFlash('Le champ "Categorie" est obligatoire', 'error');
            }
            // Si la marque est inséré
            if (!$idBrand) {
                FlashBag::addFlash('Le champ "Marque" est obligatoire', 'error');
            }
            // Si il n'y a pas d'erreur
            if (!FlashBag::hasMessages('error')) {
                
                // On enregistre les données dans la base
                if ($_FILES['productThumbnail'] && $_FILES['productThumbnail']['error'] == 0)
                {

                    if($_FILES['productThumbnail']['size'] <= 1000000)
                    {
                        
                        // Je recupere les infos du fichier grace a son nom
                        $infosfichier = pathinfo($_FILES['productThumbnail']['name']);
                        
                        // Je recup son extension
                        $extension_upload = $infosfichier['extension'];
                        
                        // Je le soumet a verification dans la liste des ext autorisée
                        $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                        if (in_array($extension_upload,$extensions_autorisees))
                        {   
                            // Si l'ext est autorisé je creer un nom de fichier aleatoire et j'y ajoute le nom du fichier puis l'extension
                            $filename = $productName.sha1(uniqid(mt_rand(), true)).'.'.$extension_upload;

                            // Et je place le fichier dans un dossier prévu a cet effet 
                            move_uploaded_file($_FILES['productThumbnail']['tmp_name'],PROJECT_DIR."/public/img"."/".$filename);

                            // TODO : A voir comment creer le dossier si il n'existe pas
                        }
                    }
                }

                // J'insere les donnée grace a ma méthode insertModel
               $this -> articleModel->insertModel($productName,$idBrand,$idCategory,$productPrice,$productDescription,$filename,1);

                // Je récupere l'id du model qui vient d'etre inséré
               $request = $this -> articleModel -> lastIdModel();
               $lastId = $request["LAST_INSERT_ID(idModel)"];

                // Je recupere Les images multiple uploadé
                if($_FILES['image']){
                
                    $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                    $namesImages = $_FILES['image']['name']; 

                    // Je boucle sur le tableau des nom des images de manier a les inséré dans un dossier imgVariation
                    for($i = 0 ; $i < count($namesImages) ; $i ++){

                        // Si il n'y  apas d'erreur
                        if($_FILES['image']['error'][$i]==0){

                            // Je recup le nom du fichier au passage de la boucle
                            $infosfichier = pathinfo($_FILES['image']['name'][$i]);
                            $extension_upload = $infosfichier['extension'];
                            
                            if (in_array($extension_upload,$extensions_autorisees))
                            {   
                                $fileMultipname = $productName.sha1(uniqid(mt_rand(), true)).'.'.$extension_upload;
                                
                                move_uploaded_file($_FILES['image']['tmp_name'][$i],PROJECT_DIR."/public/img/imgVariation"."/".$fileMultipname);

                                $this-> articleModel ->addImage($lastId,$fileMultipname);
                                
                            }
                        }
                    }     
                }

               
                // Message flash
                FlashBag::addFlash('Article ajouté avec succès.');
                
                // Redirection vers le dashboard admin
                $this->redirect('admin');
            }
            
        }

        $categories = $this -> categoryModel -> getCategories();
        $colors = $this -> categoryModel -> getColors();
        $sizes = $this -> categoryModel -> getSizes();
        $brands = $this -> categoryModel -> getBrands();
        $models = $this -> categoryModel -> getModels();


        return $this->render('admin/add/addModel.admin',[
            'categories' => $categories,
            'colors' => $colors,
            'sizes' => $sizes,
            'brands' => $brands,
            'models' => $models,
            
        ]);
    }



    public function editModel(){
        include LIBRARY_DIR .'/adminCheck.php';


         
        // if (!array_key_exists('model_id', $_GET) || ! isset($_GET['model_id']) || !ctype_digit($_GET['model_id'])){
        //     http_response_code(404); // On modifie le code de status de la réponse HTTP 
        //     echo '404 NOT FOUND'; // On affiche un message à l'internaute
        //     exit; // On arrête le script PHP, on n'a plus rien à faire ! 
        // }
        
        
       
        $idMod= (int) $_GET['model_id'];
        $model = $this ->articleModel -> getOneModel($idMod);
        $cat = $this -> categoryModel -> getAllCategories();
        $brands = $this -> categoryModel-> getBrands();
        $imgPat = $model['img'];
        $imgPathToDel = $model['img'];
        $filename = $imgPathToDel;
        $images = $this->articleModel ->readImagevar($idMod);
        dump($images);
            
        
        if (!empty($_POST)) {
            $productName= trim($_POST['productName']);
            $idBrand= intval($_POST['productBrand']);
            $idCategorie= intval($_POST['productCategory']);
            $prix= intval($_POST['productPrice']);
            $desc= trim($_POST['productDescription']);
            $imgPat= trim($_FILES['productThumbnail']['name']);
            
            

            if ($_FILES['productThumbnail'] && $_FILES['productThumbnail']['error'] == 0){

                if($_FILES['productThumbnail']['size'] <= 1000000)
                {
                    // On recupere les info du fichier avec pathinfo
                    $infosfichier = pathinfo($_FILES['productThumbnail']['name']);
                    // On recupere son extension
                    $extension_upload = $infosfichier['extension'];
                    // On verifie qu'elle sois présentes dans les extension autorisé
                    $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                    if (in_array($extension_upload,$extensions_autorisees))
                    {   
                        $filename = $productName.sha1(uniqid(mt_rand(), true)).'.'.$extension_upload;
                        move_uploaded_file($_FILES['productThumbnail']['tmp_name'],PROJECT_DIR."/public/img"."/".$filename);
                        $imgToDel = PROJECT_DIR."/public/img"."/".$imgPathToDel;
                        // Enlever l'image si elle existe déja !!
                        unlink($imgToDel);
                    }
                }      
            }
            
            if($_FILES['image']){
                
                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                $namesImages = $_FILES['image']['name']; 
                

                // Je Récupere les images associé précedentes associé au model dans le but recuper les path et ainsi les supprimé dans le dossier imgVariation
                $imagesToDelete = $this -> articleModel -> readImageVar($idMod);
                
                // Je supprime les images en base de donnée
                $this-> articleModel -> deleteImagesFromModel($idMod);


                
               // Je boucle sur le tableau des nom des images de manier a les inséré dans un dossier imgVariation
                for($i = 0 ; $i < count($namesImages) ; $i ++){
                        
                    // Si il n'y  apas d'erreur
                    if($_FILES['image']['error'][$i]==0){

                        $infosfichier = pathinfo($_FILES['image']['name'][$i]);
                        $extension_upload = $infosfichier['extension'];
                        
                        if (in_array($extension_upload,$extensions_autorisees)){
                            //Je créer un nom de fichier aleatoire qui commence par le nom du model et qui fini par le nom de l'extension 
                            $fileMultipname = $productName.sha1(uniqid(mt_rand(), true)).'.'.$extension_upload;
                            
                            // Je le place dans le dossier prévu a cet effet
                            move_uploaded_file($_FILES['image']['tmp_name'][$i],PROJECT_DIR."/public/img/imgVariation"."/".$fileMultipname);


                            // TODO Fait une procédure qui recupere le path des images associé au model !!!
                            $this-> articleModel ->addImage($idMod,$fileMultipname);
                            
                            // $imgToDel = PROJECT_DIR."/public/img"."/".$imgPathToDel;
                            // Enlever l'image si elle existe déja !!
                            
                            
                        }
                        
                    }
                }  

                // Je boucle sur les images a supprimé et je recrer le chemin absolu pour supprimé le fichier
                if(count($imagesToDelete)>0 && $imagesToDelete != false){

                    foreach ($imagesToDelete as $key => $val){
                
                        unlink(PROJECT_DIR."/public/img/imgVariation"."/".$val['imgPath']);

                    }
                }
                
                
                
               
            }
            
            $this -> articleModel->editModel($productName,$idBrand,$idCategorie,$prix,$desc,$filename,$idMod);
        }
            

        return $this->render('admin/edit/editModel.admin',[
            
            'idBrand' => $idBrand ?? $model['idMarque'],
            'idMod' => $idMod ?? $model['idModel'],
            'idCategorie' => $idCategorie??$model['idCategorie'],
            'prix' => $prix ?? $model['prix'],
            'desc' => $desc ?? $model['details'],
            'imgPat' => $imgPat?? $model['img'],
            'productName' => $productName ?? $model['libModel'],
            'model' => $model,
            'categories'=>$cat,
            'brands' => $brands,
            'images' => $images
        ]);
    }

    public function deleteModel(){
        include LIBRARY_DIR .'/adminCheck.php';

        if (!array_key_exists('model_id', $_GET) || ! isset($_GET['model_id']) || !ctype_digit($_GET['model_id'])){
            http_response_code(404); // On modifie le code de status de la réponse HTTP 
            echo '404 NOT FOUND'; // On affiche un message à l'internaute
            exit; // On arrête le script PHP, on n'a plus rien à faire ! 
        }

        $idModel = (int)$_GET['model_id'];
        $result = $this -> articleModel -> deleteModel($idModel);
        print($result ? $idModel : '-1');
    }

}