<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 18/03/2018
 */
?>
<section id="tpsem05">
    <fieldset id="tp05search">
        <legend>Groupe recherché</legend>
        <form name="recherche" id="formSearch">
            <input type="text" id="txtSearch" name="txtSearch" placeholder="nom du groupe recherché">
            <br>
            <div>
                <span title="Début (Begin)">
                    <label for="B"><<</label>
                    <input type="radio" id="B" value="B" name="posSearch">B</input>
                </span>
                <span title="In">
                    <label for="I">  ></label>
                    <input type="radio" id="I" value="I" name="posSearch" checked>I</input>
                    <label for="I"><</label>
                </span>
                <span title="Fin (End)">
                    <input type="radio" id="E" value="E" name="posSearch">E</input>
                    <label for="E"> >> </label>
                </span>
            </div>
        </form>
    </fieldset>
    <fieldset id="tp05select">
        <legend>Suggestion</legend>
        <form name="suges" id="formSelect" name="select">
            <select title="Choisissez le groupe à afficher">
            </select>
        </form>
    </fieldset>
    <fieldset id="tp05result">
        <legend>Liste des cours</legend>
        <p>Pas de groupe sélectionné</p>
        <div></div>
    </fieldset>
</section>
