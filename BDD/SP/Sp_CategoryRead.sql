DELIMITER //
DROP PROCEDURE IF EXISTS Sp_CategoryRead//
CREATE PROCEDURE Sp_CategoryRead(id int) 
BEGIN
    SELECT * 
	from categorie
    where idCategorie = id;
    
END//