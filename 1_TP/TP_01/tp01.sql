-- TP01 
----------------------------------------------------------------
-- Combien d'étudiants ? 
select count(*) as nbrEtudiants 
from etudiants;
-- Combien d'étudiants en 1TL1 ?
select count(*) as nbrEtudiants
from etudiants
where classe = "1TL1";
-- Combien d'étudiants dans tous les groupes ? 
select classe, count(*) as nbr
from etudiants
group by classe;
-- Combien d'étudiants par année-section ?
select substring(Classe,1, 2) as AnnSec, count(*) as nbr
from etudiants
group by AnnSec;
-- Combien d'étudiants par section ?
select substring(Classe, 2, 1) as sec, count(*)
from etudiants
group by sec;
-- Combien de fois reviennent chaque prénom ?
select Prenom, count(*) as nbr
from etudiants
group by Prenom;
-- Quel est le plus grand nombre de fois qu'un prénom revient ? 
select count(Prenom) as nbr
from etudiants
where max(nbr)
group by Prenom
order by count(*) desc;
-- Quel(s) prénom(s) revien(ne)t le plus souvent ?
select prenom
from etudiants
group by prenom
order by count(prenom) desc limit 2;
-- Y-a-t-il un(des) cas d'homonymie dans étudiant? 
select nom, prenom, count(*) as nbr
from etudiants
group by nom, prenom
having count(*) > 1;
-- idem dans étudiant_2
select nom, prenom, count(*) as nbr
from etudiants_2
group by nom, prenom
having count(*) > 1
-- Quels sont les étudiants concernés par une homonymie dans étudiants ?

-- dans etudiants_2 ?
