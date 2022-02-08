<?php 

namespace App\Framework;


abstract class AbstractController {

    public function render(string $template, array $data = [])
    {
        $data = Tools::secureArray($data);

        extract($data);
    
        ob_start();
    
        include TEMPLATE_DIR . '/base.phtml';
    
        return ob_get_clean();
    }

    public function redirect(string $routename, array $params = [])
    {
        $url = buildUrl($routename, $params);

        header('Location: ' . $url);
        exit;
    }

}