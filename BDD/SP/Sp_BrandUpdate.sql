DELIMITER //
DROP PROCEDURE IF EXISTS Sp_BrandUpdate//
CREATE PROCEDURE Sp_BrandUpdate(libBr text, idBr int) 
BEGIN
    update marque 
	set libMarque = libBr
	where idMarque = idBr;
    
END//