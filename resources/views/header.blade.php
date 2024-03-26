<header>
    <div class="container">
        <div class="row py-2">
            <div class="col-3">
                <img src="{{ asset('img/logo.png') }}">
            </div>
            <div class="col-9 text-end">
                <a href="#" class="link-blue me-3">Kontakty a čísla na oddelenia</a>

                <select name="lang" class="form-select d-inline-block w-auto border-0">
                    <option value="en">EN</option>
                    <option value="sk">SK</option>
                </select>

                <input name="search" type="text" class="form-control d-inline-block w-25">
                <i class="bi bi-search position-absolute"></i>

                <button class="btn btn-green">Prihlásenie</button>
            </div>
        </div>
        <div class="row py-2">
            <nav>
                <a href="#">O nás</a>
                <a href="#">Zoznam miest</a>
                <a href="#">Inšpekcia</a>
                <a href="#">Kontakt</a>
            </nav>
        </div>
    </div>
</header>
