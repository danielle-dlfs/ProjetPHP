<section id="tpsem05">
    <fieldset id="tp05search">
        <legend>Groupe recherché</legend>
        <form action="" name="recherche" id="formSearch">
            <input type="text" id="txtSearch" name="txtSearch" class="I" placeholder="nom du groupe recherché">
            <div>
                <span title="Début (Begin)">
                    <label for="B">&#8676;</label>
                    <input type="radio" id="B" value="B" name="posSearch">B
                </span>
                <span title="In">
                    <label for="I">&#8676;</label>
                    <input type="radio" id="I" value="I" name="posSearch" checked>I
                    <label for="I">&#8677;</label>
                </span>
                <span title="Fin (End)">
                    <input type="radio" id="E" value="E" name="posSearch">E
                    <label for="E">&#8677;</label>
                </span>
            </div>
        </form>
    </fieldset>
    <fieldset id="tp05select">
        <legend>Suggestion</legend>
        <form action="formSubmit.html" name="suges" id="formTP05" name="select">
            <select title="Choisissez le groupe à afficher" id="formSelect" size="10">
                <option value="">a</option>
                <option value="" class="deja">b</option>
            </select>
        </form>
    </fieldset>
    <fieldset id="tp05result">
        <legend>Liste des cours</legend>
        <p>Pas de groupe sélectionné</p>
        <div></div>
    </fieldset>
</section>
<style>
    #tpsem05 {
        display : flex;
        flex-direction : row;
        flex-flow : row wrap;
    }

    #formSearch {
        text-align : center;
    }

    #formSearch label {
        margin: 0;
        font-size: 1.5em
    }

    #txtSearch {
        height: 2em;
        width: 12em;
        font-size: 1.25em;
    }

    #txtSearch.E {
        text-align: right;
    }

    #txtSearch.I {
        text-align: center;
    }

    #txtSearch.B {
        text-align: left;
    }

    #formSearch span {
        margin: 0.25em;
        padding: 0.25em;
        box-shadow: 0.05em 0.05em darkgrey;
        border-radius: 1em;
        background-color: rgba(255, 255, 255, 0.67);
    }

    #formSelect {
        width: 10em;
        overflow-y: scroll;
    }

    #formSelect option.deja::before {
        content:'\21AA \00a0';
    }
</style>