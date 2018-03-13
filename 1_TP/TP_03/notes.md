# Procédures et fonctions 

## Premiere procédure `mc_AllGroup()`  
Checker ce que `DELIMITER` signifie  


```sql
CREATE PROCEDURE `mc_allGroup`()
BEGIN
	SELECT * 
    FROM minicampus.class;
END   
```

`call 1718he201409.mc_allGroup();`