# TP02 - P2 
## Phase 1 - MYSQL WORKBENCH 
1. Afficher les bases de données : `SHOW TABLES FROM test`   
2. Afficher la liste des tables disponibles : `SHOW COLUMN FROM etudiants`  
  
Checker la commande use en SQL  => permet de "mettre en gars" dans le workbench  

## Phase 2 : Reverse Engineering 
`SHOW TABLES FROM world`  
`SHOW TABLES FROM minicampus`  
  
Creation de schéma relationnel : CTRL+R   

## Phase 3 : Requête dans DB mutlitable
### Dans _World_  

1. **Travail préparatoire mono table**
    - Afficher la plus grande superficie pour un pays  
    ```sql
    SELECT MAX(SurfaceArea) AS laPlusGrande  
    FROM country
    ``` 
    - Afficher le pays qui a la plus petite superficie  
    ```sql
    SELECT Name, SurfaceArea AS 'laPluPetiteSuperf.(km²)'
    FROM country
    WHERE SurfaceArea = (SELECT MIN(SurfaceArea) FROM country)
    ```
    **NB: faire le min directement dans le select renvoit Aruba et non le vatican, pourquoi (meme valeur de surfaceArea) ?**   

    - Afficher la superfie totale du "BENELUX"  
    ```sql
    SELECT 'benelux', SUM(SurfaceArea) AS surface
    FROM country
    WHERE code='BEL' or code='NLD' or code='LUX'
    ORDER BY 'benelux'
    ```

2. **Travail multi table**

   - Pour les pays du "BENELUX", donnez : le nom du pays, la population du pays et la population totale des villes du pays reprise dans la table des villes  
    ````sql
    SELECT co.Name AS Pays, co.Population AS PopPays , SUM(ci.Population) AS PopTotVille
    FROM country AS co JOIN city AS ci
    	ON co.Code = ci.CountryCode
    WHERE co.code='BEL' or co.code='NLD' or co.code='LUX'
    GROUP BY Pays
    ````
   - Pour les pays du "BENELUX", donnez en ordre décroissant sur les pourcentages, les noms et les pourcentages des langues parlées
(pensez à diviser par 3 vos résultats car il y a 3 pays)  
    ````sql
    
    ````
   - Pour le "monde", donnez le pourcentage de personnes qui parlent une langue officielle   
    ````sql
    
    ````

### Dans _MiniCampus_
1. **mono (?) table**

    - Afficher la liste des classes de base (celles qui n'ont pas de parent)  
    ````sql
        
    ````
    - Afficher les filles d'une section donnée (p.e. TI)  
    ````sql
        
    ````    
    - Afficher les filles des filles d'une classe donnée (p.e. TI)
    ````sql
        
    ```` 
2. **multi table**
    - Afficher la liste des cours (code, faculté et libellé) pour une classe (p.e. 1TL2) donnée
    ````sql
        
    ````    
    
## A faire à domicile
1. **dans _world_ : mono table**  

      - Afficher la superfie de chacune des regions d'europe  
    ````sql
        
    ````       
      - Pour chacun des continents, afficher le(s) pays qui a(ont) eu leur indépendence le plus récemment  
    ````sql
        
    ```` 
    
2. **dans _world_ : multi table**  
    - Pour le "monde", donnez le pourcentage de personnes qui ne parlent pas une langue officielle  
     _Comprenez : personnes répertoriées comme ne parlant pas une langue officielle  
     ou : répertoriées comme parlant une langue non-officielle_
    ````sql
        
    ```` 
3. **dans _Minicampus_ : mono table** 

    - Afficher la liste des facultés de base (celles qui n'ont pas de parent)
    ````sql
        
    ```` 
    - Afficher les filles d'une faculté donnée (p.e. TI)
    ````sql
        
    ```` 
4. **dans _Minicampus_ : multi table**  

    - Pour tous les étudiants, afficher les informations suivantes :
        groupe, matricule, nom, prénom et email (construit : matricule@students...)
    ````sql
        
    ```` 
    - pour chacune des facultés, afficher ces informations précédées du nom de son parent.
    ````sql
        
    ```` 