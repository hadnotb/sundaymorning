DELIMITER //
DROP PROCEDURE IF EXISTS Sp_ArticlesRead//
CREATE PROCEDURE Sp_ArticlesRead() 
BEGIN
    Select *  
	from article;
END//