/* SCRIPT PROCEDURES STOCKEES ET FONCTIONS */

-- Stored Procedure mc_allGroups

CREATE PROCEDURE `mc_allGroups`()
BEGIN
	SELECT * 
    FROM minicampus.class;
END

-- Stored Procedure mc_coursesGroup

CREATE PROCEDURE `mc_coursesGroup`(IN groupe VARCHAR(10))
BEGIN
    SELECT code, faculte, intitule FROM minicampus.cours c 
        JOIN minicampus.course_class cc ON c.code = cc.cours_id 
        JOIN minicampus.class cl ON cc.class_id = cl.id 
	WHERE cl.nom = groupe
	ORDER BY code;
END

-- Stored Procedure mc_group

CREATE PROCEDURE `mc_group`(groupe VARCHAR(10))
BEGIN
	SELECT * 
	FROM minicampus.class 
	WHERE nom = groupe;
END

-- Stored Procedure whoIs

CREATE PROCEDURE `whoIs`(pseudo char(20), mot char(32))
BEGIN
	select uId as id, uPseudo as pseudo, uEmail as email from tbuser
    where uPseudo = pseudo and uMdp = hashage(uSemence, mot);
END

-- Stored Procedure userProfil

CREATE PROCEDURE `userProfil`(id int)
BEGIN
    select * from tbprofil
    where pId in (select pId from tbuserprofil
    where uId = id)
    order by pId desc;
END

-- Function hashage 

CREATE FUNCTION `hashage`(sem char(32), mot char(32)) 
RETURNS char(100) CHARSET utf8
BEGIN
    return MD5(CONCAT(sem, mot));
END