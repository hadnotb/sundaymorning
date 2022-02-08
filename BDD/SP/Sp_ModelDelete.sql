DELIMITER //
DROP PROCEDURE IF EXISTS Sp_ModelDelete//
CREATE PROCEDURE Sp_ModelDelete(id int) 
BEGIN
    Delete 
	from model
    where idModel = id;
END//