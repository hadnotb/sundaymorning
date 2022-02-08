DELIMITER //
DROP PROCEDURE IF EXISTS Sp_ModelsRead//
CREATE PROCEDURE Sp_ModelsRead() 
BEGIN
    SELECT libArticle, idArticle
    from   model_article;
END//


