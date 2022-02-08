
DELIMITER //
DROP PROCEDURE IF EXISTS Sp_ColorRead//
CREATE PROCEDURE Sp_ColorRead(id int) 
BEGIN
    SELECT * 
	from couleur
    where idCouleur = id;
    
END//