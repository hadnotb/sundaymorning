<?php 

/**
 * On définit le tableau des routes : on associe à chaque route un fichier PHP 
 * qui jouera la rôle de contrôleur. Par exemple pour la page d'accueil, c'est un fichier home.php
 * qui sera inclus. Pour la page Article, ce sera un fichier article.php, etc
 */
$routes = [

    // Route de la page d'accueil
    'homepage' => [
        'path' => '/',
        'controller' => 'Home',
        'method' => 'index'
    ],
    'article' => [
        'path' => '/article',
        'controller' => 'Article',
        'method' => 'index',
        'isParam' => true
    ],
    'search-article' => [
        'path' => '/search-article',
        'controller' => 'Category',
        'method' => 'searchArticle'
    ],
    'category' => [
        'path' =>'/category',
        'controller' =>'Category',
        'method' => 'index'
    ],
    'search' => [
        'path' =>'/search',
        'controller' =>'Category',
        'method' => 'searchArticle'
    ],
    'login' => [
        'path' =>'/login',
        'controller' =>'Auth',
        'method' => 'login'
    ],
    'signup' => [
        'path' => '/signup',
        'controller' => 'Account',
        'method' => 'signup'
    ],
    'account' => [
        'path' => '/account',
        'controller' => 'Account',
        'method' => 'accountPage'
    ],
    'logout' => [
        'path' => '/logout',
        'controller' => 'Auth',
        'method' => 'logout'
    ],
    // ADMIN_GENERAL///////////////////////////////////////////
    'admin' => [
        'path' => '/admin',
        'controller' => 'Admin\\Admin',
        'method' => 'index'
    ],
    'adminProduct' => [
        'path' => '/admin/product',
        'controller' => 'Admin\\Admin',
        'method' => 'product'
    ],
    // ADMIN_ITEM /////////////////////////////////////
    'adminModel' => [
        'path' => '/admin/model',
        'controller' => 'Admin\\ModelAdmin',
        'method' => 'model'
    ],
    'adminCategory' => [
        'path' => '/admin/category',
        'controller' => 'Admin\\CategoryAdmin',
        'method' => 'category'
    ],
    'adminBrand' => [
        'path' => '/admin/brand',
        'controller' => 'Admin\\BrandAdmin',
        'method' => 'brand'
    ],
    'adminArticle' => [
        'path' => '/admin/article',
        'controller' => 'Admin\\ArticleAdmin',
        'method' => 'article'
    ],
    'adminSize' => [
        'path' => '/admin/size',
        'controller' => 'Admin\\SizeAdmin',
        'method' => 'size'
    ],
    'adminColor' => [
        'path' => '/admin/color',
        'controller' => 'Admin\\ColorAdmin',
        'method' => 'color'
    ],
    // AJOUT///////////////////////////////////////////////////////
    'addArticle' => [
        'path' => '/admin/addArticle',
        'controller' => 'Admin\\ArticleAdmin',
        'method' => 'addArticle'
    ],
    'addBrand' => [
        'path' => '/admin/addBrand',
        'controller' => 'Admin\\BrandAdmin',
        'method' => 'addBrand'
    ],
    'addModel' => [
        'path' => '/admin/addModel',
        'controller' => 'Admin\\ModelAdmin',
        'method' => 'addModel'
    ],
    'addCategory' => [
        'path' => '/admin/addCategory',
        'controller' => 'Admin\\CategoryAdmin',
        'method' => 'addCategory'
    ],
    'addSize' => [
        'path' => '/admin/addSize',
        'controller' => 'Admin\\CategoryAdmin',
        'method' => 'sizeControl'
    ],
    'addColor' => [
        'path' => '/admin/addColor',
        'controller' => 'Admin\\ColorAdmin',
        'method' => 'addColor'
    ],
    // EDIT/////////////////////////////////////////////////
    'editModel' => [
        'path' => '/admin/editModel',
        'controller' => 'Admin\\ModelAdmin',
        'method' => 'editModel'
    ],
    'editArticle' => [
        'path' => '/admin/editArticle',
        'controller' =>'Admin\\ArticleAdmin',
        'method' => 'editArticle'
    ],
    'editCategory' => [
        'path' => '/admin/editCategory',
        'controller' =>'Admin\\CategoryAdmin',
        'method' => 'editCategory'
    ],
    'editSize' => [
        'path' => '/admin/editSize',
        'controller' =>'Admin\\SizeAdmin',
        'method' => 'editSize'
    ],
    'editColor' => [
        'path' => '/admin/editColor',
        'controller' =>'Admin\\ColorAdmin',
        'method' => 'editColor'
    ],
    'editBrand' => [
        'path' => '/admin/editBrand',
        'controller' =>'Admin\\BrandAdmin',
        'method' => 'editBrand'
    ],
    // DELETE////////////////////////////////////////////////////
    'deleteModel' => [
        'path' => '/admin/deleteModel',
        'controller' => 'Admin\\ModelAdmin',
        'method' => 'deleteModel'
    ],
    'deleteArticle' => [
        'path' => '/admin/deleteArticle',
        'controller' =>'Admin\\ArticleAdmin',
        'method' => 'deleteArticle'
    ],
    'deleteCategory' => [
        'path' => '/admin/deleteCategory',
        'controller' =>'Admin\\CategoryAdmin',
        'method' => 'deleteCategory'
    ],
    'deleteSize' => [
        'path' => '/admin/deleteSize',
        'controller' =>'Admin\\SizeAdmin',
        'method' => 'deleteSize'
    ],
    'deleteColor' => [
        'path' => '/admin/deleteColor',
        'controller' =>'Admin\\ColorAdmin',
        'method' => 'deleteColor'
    ],
    'deleteBrand' => [
        'path' => '/admin/deleteBrand',
        'controller' =>'Admin\\BrandAdmin',
        'method' => 'deleteBrand'
    ],

];

define('ROUTES', $routes);

return $routes;