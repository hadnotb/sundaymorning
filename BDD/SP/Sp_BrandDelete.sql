DELIMITER //
DROP PROCEDURE IF EXISTS Sp_BrandDelete//
CREATE PROCEDURE Sp_BrandDelete(id int) 
BEGIN
    Delete 
	from marque
    where idMarque = id;
END//