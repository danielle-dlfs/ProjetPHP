# ProjetPHP
**_Avancement du cours de PHP - DEV WEB_**   
<hr>
  
Lien du cours > https://devweb.ephec.be/TP/2T/  <> https://193.190.65.92/TP/2T/  
Attention ! A LIRE !!!

NE PAS OUBLIER DE METTRE VOTRE FICHIER dbConnect.inc.php dans les dossiers INC de vos phases  
NE PAS OUBLIER DE METTRE VOS IDENTIFIANTS A VOUS DANS LE FICHIER DE config.ini.php DANS LA PHASE 4 !  
POUR CE QUI EST DE LA DB, LES SCRIPTS SONT DANS LE DOSSIER TP_8, AVEC LE TP11 IL FAUT RAJOUTER LES IMAGES POUR LES USERS  
NE PAS OUBLIER DE CONVERTIR LES IMAGES EN BASE 64 AVEC LA COMMANDE NOTEE PLUS BAS  

## Liens vers mes phases :  

- [Phase 0](https://devweb.ephec.be/HE201409/2_SITEX/phase_00/) | 100% finie   
- [Phase 1](https://devweb.ephec.be/HE201409/2_SITEX/phase_01/) | 100% finie   
- [Phase 2](https://devweb.ephec.be/HE201409/2_SITEX/phase_02/) | 100% finie  
- [Phase 3](https://devweb.ephec.be/HE201409/2_SITEX/phase_03/) | 100% finie   
- [Phase 4](https://devweb.ephec.be/HE201409/2_SITEX/phase_04/index.php) | 100% finie   
==> NB : pour les images BLOB dans la BD (que json_encode ne supporte pas (cfr TP11), faites une UPDATE dans la DB pour chaque pId (de 1 à 8) :   
> `UPDATE tbprofil SET pIcon = concat('data:image/png;base64,' , to_base64(pIcon)) where pId between 1 and 8`  

- [Phase 4.5 - droits](https://devweb.ephec.be/HE201409/2_SITEX/phase_04.05%20-%20droits/index.php) | work in progress  

## Liens des consignes :  

> [Phase 0](https://devweb.ephec.be/TP/2T/1718sitex_00.php)  
> [Phase 1](https://devweb.ephec.be/TP/2T/1718sitex_01.php)  
> [Phase 2](https://devweb.ephec.be/TP/2T/1718sitex_02.php)  
> [Phase 3](https://devweb.ephec.be/TP/2T/1718sitex_03.php)   
> [Phase 4](https://devweb.ephec.be/TP/2T/1718sitex_04.php)  


> [TP 02](https://devweb.ephec.be/TP/2T/tp1718_sem02.php)  
> [TP 03](https://devweb.ephec.be/TP/2T/tp1718_sem03.php)  
> [TP 04](https://devweb.ephec.be/TP/2T/tp1718_sem04.php)  
> [TP 05](https://devweb.ephec.be/TP/2T/tp1718_sem05.php)  
> [TP 06](https://devweb.ephec.be/TP/2T/tp1718_sem06.php) ==> pour les images voir [TP 08 - 2016-2017](http://193.190.65.94/TP/2T/tp1617_sem08.php)   
> ~~TP 07~~ ==> semaine inter  
> [TP 08](https://devweb.ephec.be/TP/2T/tp1718_sem08.php)  
> [TP 09](https://devweb.ephec.be/TP/2T/tp1718_sem09.php)   
> [TP 10](https://devweb.ephec.be/TP/2T/tp1718_sem10.php)  
> [TP 11](https://devweb.ephec.be/TP/2T/tp1718_sem11.php)  
> [TP 12](https://devweb.ephec.be/TP/2T/tp1718_sem12.php)  

