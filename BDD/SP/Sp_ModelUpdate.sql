DELIMITER //
DROP PROCEDURE IF EXISTS Sp_ColorCreate//
CREATE PROCEDURE Sp_ColorCreate(col text) 
BEGIN
    INSERT INTO `sundaymorning`.`couleur` (`libCouleur`) 
    VALUES (col);
    
END//