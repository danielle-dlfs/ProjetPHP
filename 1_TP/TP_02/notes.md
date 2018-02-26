# TP02 - P2 
## Phase 1 - MYSQL WORKBENCH 
1. Afficher les bases de données : `SHOW TABLES FROM test`   
2. Afficher la liste des tables disponibles : `SHOW COLUMN FROM etudiants`  
  
Checker la commande use en SQL  => permet de "mettre en gars" dans le workbench  

## Phase 2 : Reverse Engineering 
`SHOW TABLES FROM world`  
`SHOW TABLES FROM minicampus`  
  
Creation de schéma relationnel : CTRL+R   

## Phase 3 
### Travail préparatoire mono table

1. Afficher la plus grande superficie pour un pays  
```sql
SELECT MAX(SurfaceArea) AS laPlusGrande  
FROM country
```
  
2. Afficher le pays qui a la plus petite superficie  
````sql
SELECT Name, SurfaceArea AS 'laPluPetiteSuperf.(km²)'
FROM country
WHERE SurfaceArea = (SELECT MIN(SurfaceArea) FROM country)
```` 
**NB: faire le min directement dans le select renvoit Aruba et non le vatican, pourquoi ?**   

- Afficher la superfie totale du "BENELUX"  
```sql
SELECT 'benelux', SUM(SurfaceArea) AS surface
FROM country
WHERE code='BEL' or code='NLD' or code='LUX'
ORDER BY 'benelux'
```

### Travail multi table

1. Pour les pays du "BENELUX", donnez : le nom du pays, la population du pays et la population totale des villes du pays reprise dans la table des villes  
````sql

````
2. Pour les pays du "BENELUX", donnez en ordre décroissant sur les pourcentages, les noms et les pourcentages des langues parlées
(pensez à diviser par 3 vos résultats car il y a 3 pays)  
````sql

````
3. Pour le "monde", donnez le pourcentage de personnes qui parlent une langue officielle   
````sql

````