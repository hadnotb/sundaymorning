DELIMITER //
DROP PROCEDURE IF EXISTS Sp_ColorDelete//
CREATE PROCEDURE Sp_ColorDelete(id int) 
BEGIN
    Delete 
	from couleur
    where idCouleur = id;
END//