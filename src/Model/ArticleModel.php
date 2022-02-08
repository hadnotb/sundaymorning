<?php 

namespace App\Model;

use App\Framework\AbstractModel;

class ArticleModel extends AbstractModel {

    function getOneModel(int $id)
    {
        $sql = 'call Sp_ModelRead(:idMod)'; 
        $model = $this ->database ->getOneResult($sql,['idMod'=> $id]);
        return $model;

    }
    function getOneArticle(int $id){
        $sql = 'call Sp_ArticleRead(:idArt)'; 
        $article = $this ->database ->getOneResult($sql,['idArt'=> $id]);
        return $article;
    }
    function getOneArticleInfo(int $id){
        $sql = 'call Sp_modelArticleLire(:idArt)'; 
        $article = $this ->database ->getOneResult($sql,['idArt'=> $id]);
        return $article;
    }
   
    public function getAllArticle(){
        
        $sql = 'call Sp_ArticlesRead()'; 
        $products = $this ->database ->getAllResults($sql);
        return $products;
    }
    public function getAllArticles(){
        
        $sql = 'call Sp_ArticlesRead()'; 
        $products = $this ->database ->getAllResults($sql);
        return $products;
    }
    public function getAllModel(){
        $sql = 'call Sp_ModelsRead()'; 
        $products = $this ->database ->getAllResults($sql);
        return $products;
    }
    function getSeveralArticle()
    {
        $sql = 'call Sp_getSeveralRandomArticle()';
        $articles = $this -> database -> getAllResults($sql);
        return $articles;
    }
    function insertModel($productName,$idBrand,$idCategorie,$prix,$desc,$imgPat){
        $sql = 'call Sp_ModelsCreate(:prName,:idBr,:idCat,:price,:details,:imgPath)';
        return $this -> database -> insert($sql,[
            'prName'=> $productName,
            'idBr'=> $idBrand,
            'idCat'=> $idCategorie,
            'price'=> $prix,
            'details'=> $desc,
            'imgPath'=> $imgPat
            
        ]);
    }

    function insertArticle($idArt,$idCol,$idSz,$nbEle){
        $sql = 'call Sp_ArticleCreate(:a,:b,:c,:d)';
        $return = $this -> database -> insert($sql,[
            'a'=>$idArt,
            'b'=>$idCol,
            'c'=>$idSz,
            'd'=>$nbEle
        ]);
    }

    function editModel($productName,$idBrand,$idCategorie,$prix,$desc,$imgPat,$idMod){
        $sql = 'call Sp_ModelUpdate(:a,:b,:c,:d,:e,:f,:h)';
        $return = $this -> database -> insert($sql,[
            'a'=>$productName,
            'b'=>$idBrand,
            'c'=>$idCategorie,
            'd'=>$prix,
            'e'=>$desc,
            'f'=>$imgPat,
            'h'=>$idMod,

        ]);
    }
    function editArticle($idMod,$idCol,$idSz,$nbEle,$idArt){
        $sql = 'call Sp_ArticleUpdate(:a,:b,:c,:d,:e)';
        $return = $this -> database -> insert($sql,[
            'a'=>$idMod,
            'b'=>$idCol,
            'c'=>$idSz,
            'd'=>$nbEle,
            'e'=>$idArt
        ]);
        
    }

    function deleteArticle($idArt){
        
        $sql ='call Sp_ArticleDelete(:idArt)';
        $result = $this -> database -> executeQuery($sql,[':idArt' =>$idArt]);
        return $result;
    }

    function deleteModel($idMod){
        
        $sql ='call Sp_ModelDelete(:idMod)';
        $result = $this -> database -> executeQuery($sql,[':idMod' =>$idMod]);
        return $result;
    }
    function lastIdModel(){

        $sql ='call Sp_LastIdModel()';
        $result = $this -> database -> getOneResult($sql);
        return $result;
    }
    function addImage($idModel,$imagePath){

        $sql ='call Sp_ImageCreate(:idMod,:imgPath)';
        $result = $this -> database -> insert($sql,[':idMod'=>$idModel,':imgPath'=>$imagePath]);
        return $result;
    }
    
    function deleteImagesFromModel($idModel){

        $sql ='call Sp_ImagesModelDelete(:idMod)';
        $result = $this -> database -> executeQuery($sql,[':idMod' =>$idModel]);
        return $result;
    }
    function readImageVar($idModel){
        $sql ='call Sp_ImageVarRead(:idMod)';
        $result = $this -> database -> getAllResults($sql,[':idMod' =>$idModel]);
       
        return $result;
    }
    

}