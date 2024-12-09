<form method="GET" action="/search" class="search-form__wrapper">
    <input placeholder="Search" autofocus type="text" name="q" id="q" value="{{ $query ?? '' }}" autocomplete="off" data-bangs="false">
    <div class="search-form__bangs" data-show="false">
    </div>
</form>

<dialog class="modal__wrapper">
    <p>Seems like an url... Add it to the list of redirects?</p>
    <div class="modal__actions">
        <button id="modal__yes" autofocus onclick="modal.yes()">Yes</button>
        <button id="modal__no" onclick="modal.no()">No</button>
    </div>
</dialog>
