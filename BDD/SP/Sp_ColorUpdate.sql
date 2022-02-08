DELIMITER //
DROP PROCEDURE IF EXISTS Sp_ColorUpdate//
CREATE PROCEDURE Sp_ColorUpdate(libCol text, idCol int) 
BEGIN
    update couleur 
	set libCouleur = libCol
    where idCouleur = idCol;
    
END//