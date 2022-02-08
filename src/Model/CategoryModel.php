<?php 

namespace App\Model;

use App\Framework\AbstractModel;

class CategoryModel extends AbstractModel {

    function getCategories(){

        $sql = 'call sp_ReadCategory()';
        $categories = $this ->database ->getAllResults($sql);
        return $categories;

    }
    
    function getModels(){
        $sql ='call Sp_ModelsRead()';
        $models = $this -> database -> getAllResults($sql);
        return $models;

    }
    function getBrands(){
        $sql ='call Sp_readBrand()';

        $brands = $this -> database -> getAllResults($sql);
        return $brands;
    }
    function getSizes(){
        $sql ='call Sp_readSize()';

        $sizes = $this -> database -> getAllResults($sql);
        return $sizes;
    }
    function getColors(){
        $sql ='call Sp_readColor()';

        $colors = $this -> database -> getAllResults($sql);
        return $colors;
    }
    function getCategory($idCat){
        $sql = 'call sp_CategoryRead(:idCat)';
        $categories = $this ->database ->getOneResult($sql,[':idCat' =>$idCat]);
        return $categories;
    }
    function getBrand($idbr){
        $sql = 'call sp_BrandRead(:idbr)';
        $brand = $this ->database ->getOneResult($sql,[':idbr' =>$idbr]);
        return $brand;
    }
    function getColor($idCol){
        $sql = 'call sp_ColorRead(:idCol)';
        $color = $this ->database ->getOneResult($sql,[':idCol' =>$idCol]);
        return $color;
    }
    function getSize($idSz){
        $sql = 'call sp_SizeRead(:idSz)';
        $size = $this ->database ->getOneResult($sql,[':idSz' =>$idSz]);
        return $size;
    }
    
    function getProductbyColor($id){
        $sql = 'call Sp_readArticlebyColor(:idCol)';
        $colorProducts = $this -> database -> getAllResults($sql,['idCol' =>$id]);
        return $colorProducts;
    
    }
    
    function getProductbyBrand($id){
        $sql = 'call Sp_readArticlebyBrand(:idBrd)';
        $brandProducts = $this -> database -> getAllResults($sql,['idBrd' =>$id]);
        return $brandProducts;
    
    }

    function getProductbySize($id){
        $sql = 'call Sp_readArticlebySize(:idSze)';
        $sizeProducts = $this -> database -> getAllResults($sql,['idSze' =>$id]);
        return $sizeProducts;
    }

    function getProductbyCat($id){
        $sql = 'call Sp_readArticlebyCat(:idCat)';
        $catProducts = $this -> database -> getAllResults($sql,['idCat' =>$id]);
        return $catProducts;
    }
    

   function getArticlebySearch($toSearch){
        $sql ='call Sp_brandArtCatsearch(:toSearch)';

        $results = $this -> database -> getAllResults($sql,['toSearch' => $toSearch]);
        return $results;
   }


   function insertCategory($cat){

        $sql ='call Sp_CategoryCreate(:cat)';
        $results = $this -> database -> insert($sql,[':cat' => $cat]);
        return $results;

   }

   function insertBrand($br){
        $sql ='call Sp_BrandCreate(:br)';
        $results = $this -> database -> insert($sql,[':br' => $br]);
        return $results;
   }

   function insertSize($sz){
    $sql ='call Sp_SizeCreate(:sz)';
    $results = $this -> database -> insert($sql,[':sz' => $sz]);
    return $results;
    }

    function insertColor($col){
        $sql ='call Sp_ColorCreate(:col)';
        $results = $this -> database -> insert($sql,[':col' => $col]);
        return $results;

    }

    public function getAllCategories()
    {
        $sql = 'SELECT *
                FROM categorie
                ORDER BY libCategorie';
    
        return $this->database->getAllResults($sql);
    }

    function editCategory($cat,$idCat){

        $sql ='call Sp_CategoryUpdate(:cat, :idCat)';
        $results = $this -> database -> insert($sql,[':cat' => $cat, ':idCat' =>$idCat]);
        return $results;
   }

   function editSize($sz,$idSz){

        $sql ='call Sp_SizeUpdate(:sz, :idSz)';
        $size = $this -> database -> insert($sql,[':sz' => $sz, ':idSz' =>$idSz]);
        return $size;
   }

   function editBrand($br,$idBr){

        $sql ='call Sp_BrandUpdate(:br, :idBr)';
        $brand = $this -> database -> insert($sql,[':br' => $br, ':idBr' =>$idBr]);
        return $brand;
   }

    function editColor($col,$idCol){
        
        $sql ='call Sp_ColorUpdate(:col, :idCol)';
        $color = $this -> database -> insert($sql,[':col' => $col, ':idCol' =>$idCol]);
        return $color;
   }

    function deleteCategory($idCat){

        $sql ='call Sp_CategoryDelete(:idCat)';
        $results = $this -> database -> executeQuery($sql,[':idCat' =>$idCat]);
        return $results;
    }

    function deleteSize($idSz){

        $sql ='call Sp_SizeDelete(:idSz)';
        $size = $this -> database -> executeQuery($sql,[':idSz' =>$idSz]);
        return $size;
    }

    function deleteBrand($idBr){

        $sql ='call Sp_BrandDelete(:idBr)';
        $brand = $this -> database -> executeQuery($sql,[':idBr' =>$idBr]);
        return $brand;
    }

    function deleteColor($idCol){
        
        $sql ='call Sp_ColorDelete(:idCol)';
        $color = $this -> database -> executeQuery($sql,[':idCol' =>$idCol]);
        return $color;
    }
    
    
}