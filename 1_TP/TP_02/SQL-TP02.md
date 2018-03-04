
# TP02 - P2 
## Phase 1 - MYSQL WORKBENCH 
1. Afficher les bases de données : `SHOW TABLES FROM test`   
2. Afficher la liste des tables disponibles : `SHOW COLUMN FROM etudiants`  
  
Checker la commande use en SQL  => permet de "mettre en gars" dans le workbench  

## Phase 2 : Reverse Engineering 
`SHOW TABLES FROM world`  
`SHOW TABLES FROM minicampus`  
  
Creation de schéma relationnel : CTRL+R   

## Phase 3 : Requête dans DB multitable
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
    WHERE  t''SurfaceArea = (SELECT MIN(SurfaceArea) FROM country)
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
    ```sql
    SELECT co.Name AS Pays, co.Population AS PopPays , SUM(ci.Population) AS PopTotVille
    FROM country AS co JOIN city AS ci
    	ON co.Code = ci.CountryCode
    WHERE co.code='BEL' or co.code='NLD' or co.code='LUX'
    GROUP BY Pays
   ```
   - Pour les pays du "BENELUX", donnez en ordre décroissant sur les pourcentages, les noms et les pourcentages des langues parlées
(pensez à diviser par 3 vos résultats car il y a 3 pays)  
    ```sql
    SELECT ctLang.Language AS 'language', SUM(ctLang.Percentage/100*ct.population)/(SELECT SUM(ct.population) 
    FROM country AS ct 
    WHERE ct.Code='BEL' OR ct.Code='NLD' OR ct.Code='LUX' )*100 AS 'pct'
    FROM countrylanguage AS ctLang
    INNER JOIN country AS ct
         ON ct.code = ctLang.CountryCode
    WHERE ctLang.CountryCode='BEL' OR ctLang.CountryCode='NLD' OR ctLang.CountryCode='LUX'
    GROUP BY language
    ORDER BY pct DESC;
    ```
   - Pour le "monde", donnez le pourcentage de personnes qui parlent une langue officielle   
    ```sql
    SELECT SUM((ctLang.Percentage/100)*ct.population)/(SELECT SUM(ct.population) FROM world.country AS ct )*100 AS '%_langueOfficielle'
    FROM countryLanguage AS ctLang
    INNER JOIN country AS ct
        ON ct.code = ctLang.CountryCode
    WHERE ctLang.isOfficial = 'T';
    ```

### Dans _MiniCampus_
1. **mono (?) table**

    - Afficher la liste des classes de base (celles qui n'ont pas de parent)  
    ```sql
    SELECT * 
    FROM faculte 
    WHERE codeParent IS NULL; 
    ```
    - Afficher les filles d'une section donnée (p.e. TI)  
    ```sql
    SELECT nom AS 'nomFilles(TI)' 
    FROM class WHERE parent_id = (SELECT id FROM class WHERE nom = 'TI');
    ```    
    - Afficher les filles des filles d'une classe donnée (p.e. TI)
    ````sql
    SELECT nom AS 'nomPetitesFilles(TI)' 
    FROM class 
    WHERE parent_id BETWEEN 2 AND 4;
    ```` 
2. **multi table**
    - Afficher la liste des cours (code, faculté et libellé) pour une classe (p.e. 1TL2) donnée
    ```sql
    SELECT cours.code, cours.intitule 
    FROM cours INNER JOIN course_class 
         ON cours.code = course_class.cours_id 
    INNER JOIN class 
         ON class.id = course_class.class_id 
    WHERE class.nom='1TL2';
    ```    
    
## A faire à domicile
1. **dans _world_ : mono table**  

      - Afficher la superfie de chacune des regions d'europe  
    ```sql
    SELECT ct.Region, SUM(ct.SurfaceArea) AS SurfaceArea
    FROM country AS ct
    WHERE ct.Continent = 'Europe' AND ct.Region LIKE '%Europe'
    GROUP BY ct.Region;  
    ```       
      - Pour chacun des continents, afficher le(s) pays qui a(ont) eu leur indépendence le plus récemment  
    ```sql
    SELECT ct1.Name, ct1.Continent, ct1.IndepYear
    FROM country AS ct1
    JOIN (SELECT ct.Continent, MAX(ct.IndepYear) AS 'maxIndepYear' 
    	FROM country AS ct 
        GROUP BY Continent) ct2
    ON ct1.Continent = ct2.Continent AND ct1.IndepYear = ct2.maxIndepYear
    ORDER BY ct1.Continent, ct1.Name;    
    ``` 
    
2. **dans _world_ : multi table**  
    - Pour le "monde", donnez le pourcentage de personnes qui ne parlent pas une langue officielle  
     _Comprenez : personnes répertoriées comme ne parlant pas une langue officielle  
     ou : répertoriées comme parlant une langue non-officielle_
    ````sql
    SELECT SUM((ctLang.Percentage/100)*ct.population)/(SELECT SUM(ct.population) FROM country AS ct )*100 AS '%_langueNonOfficielle'
    FROM countryLanguage AS ctLang
    INNER JOIN world.country AS ct
        ON ct.code = ctLang.CountryCode
    WHERE ctLang.isOfficial = 'F';
    ```` 
3. **dans _Minicampus_ : mono table** 

    - Afficher la liste des facultés de base (celles qui n'ont pas de parent)
    ```sql
    SELECT * 
    FROM faculte 
    WHERE codeParent IS NULL;    
    ``` 
    - Afficher les filles d'une faculté donnée (p.e. TI)
    ```sql
    SELECT * 
    FROM faculte 
    WHERE codeParent = "TI";    
    ``` 
4. **dans _Minicampus_ : multi table**  

    - Pour tous les étudiants, afficher les informations suivantes :
        groupe, matricule, nom, prénom et email (construit : matricule@students...)
    ```sql
    SELECT class.nom, UCASE(user.username) AS 'matricule', user.nom, user.prenom, CONCAT(LCASE(user.username), '@students.ephec.be') AS mail
    FROM user
    INNER JOIN class_user as cu
     	ON user.id = cu.user_id
    INNER JOIN .class
      	ON cu.class_id = class.id
    WHERE user.username LIKE 'HE%';    
    ``` 
    - pour chacune des facultés, afficher ces informations précédées du nom de son parent.
    ```sql
    SELECT f2.nom, f1.id, f1.nom, f1.code, f1.codeParent, f1.position, f1.nbEnfants
    FROM faculte f1
    INNER JOIN faculte f2
         ON f1.codeParent = f2.code
    WHERE f1.codeParent IS NOT NULL;    
    ``` 