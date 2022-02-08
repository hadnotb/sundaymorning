DELIMITER //
DROP PROCEDURE IF EXISTS Sp_CategoryDelete//
CREATE PROCEDURE Sp_CategoryDelete(id int) 
BEGIN
    Delete 
	from categorie
    where idCategorie = id;
END//