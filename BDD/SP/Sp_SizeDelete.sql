DELIMITER //
DROP PROCEDURE IF EXISTS Sp_ArticlesRead//
CREATE PROCEDURE Sp_ArticlesRead(id int) 
BEGIN
    Delete 
	from taille
    where idTaille = id;
END//