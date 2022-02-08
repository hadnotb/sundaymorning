DELIMITER //
DROP PROCEDURE IF EXISTS Sp_ModelRead//
CREATE PROCEDURE Sp_ModelRead(id int) 
BEGIN
    update categorie 
	set libCategorie = libCat
    where idCategorie = idCat;
END//

CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_ModelsRead`(id int)
BEGIN
    SELECT *
    from   model;
END