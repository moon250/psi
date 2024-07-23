<form method="GET" action="/search" class="search-form__wrapper">
    <input placeholder="Rechercher" autofocus type="text" name="q" id="q" value="{{ $query ?? '' }}">
</form>

<dialog class="modal__wrapper">
    <p>Cette recherche ressemble à une url... L'ajouter à la liste des redirections ?</p>
    <div class="modal__actions">
        <button id="modal__yes" autofocus onclick="modal.yes()">Oui</button>
        <button id="modal__no" onclick="modal.no()">Non</button>
    </div>
</dialog>
