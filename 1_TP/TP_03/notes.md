# Procédures et fonctions 

## Premiere procédure `mc_AllGroup()`  
Checker ce que `DELIMITER` signifie  


```sql
CREATE PROCEDURE `mc_allGroups`()
BEGIN
	SELECT * 
    FROM minicampus.class;
END   
```

`call 1718he201409.mc_allGroups();`

## Deuxième procédure `mc_group()`   


```sql
CREATE PROCEDURE `mc_group`(IN groupe VARCHAR(10))
BEGIN
	SELECT * 
	FROM minicampus.class 
	WHERE class.nom = groupe;
END
```

## Troisième procédure `mc_courseGroup()`  

```sql
CREATE PROCEDURE `mc_courses` (IN groupe VARCHAR(10))
BEGIN
	SELECT code, faculte, intitule as libelle
	FROM minicampus.cours
	INNER JOIN minicampus.course_class 
		ON cours.code = course_class.cours_id 
	INNER JOIN minicampus.class 
		ON class.id = course_class.class_id 
	WHERE class.nom = groupe
	ORDER BY code;
END
```