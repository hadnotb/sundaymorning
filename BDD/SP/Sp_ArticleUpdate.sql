DELIMITER //
DROP PROCEDURE IF EXISTS Sp_ArticleRead//
CREATE PROCEDURE Sp_ArticleRead(id int) 
BEGIN
    SELECT * 
	from article
    where idArticle = id;
    
END//