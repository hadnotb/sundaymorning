
DELIMITER //
DROP PROCEDURE IF EXISTS Sp_BrandRead//
CREATE PROCEDURE Sp_BrandRead(id int) 
BEGIN
    SELECT * 
	from marque
    where idMarque = id;
    
END//