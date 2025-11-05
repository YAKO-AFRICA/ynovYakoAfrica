<div class="form-grid">

    <fieldset class="mt-3 p-3">
        <legend class="float-none w-auto px-2 border rounded bg-white">
            <small>Informations Personnelles</small>
        </legend>

        <div class="row">
            <div class="form-group col-sm-12 col-md-4 col-lg-4">
                <label class="required">Civilité</label>
                <select name="civilite" required>
                    <option value="">Sélectionner</option>
                    <option value="M">M.</option>
                    <option value="Mme">Mme</option>
                    <option value="Dr">Dr</option>
                    <option value="Pr">Pr</option>
                </select>
            </div>
            <div class="form-group col-sm-12 col-md-4 col-lg-4">
                <label class="required">Nom</label>
                <input type="text" name="nom" required>
            </div>
            <div class="form-group col-sm-12 col-md-4 col-lg-4">
                <label class="required">Prénom</label>
                <input type="text" name="prenom" required>
            </div>
            <div class="form-group col-sm-12 col-md-4 col-lg-4">
                <label>Genre</label>
                <div class="radio-group">
                    <label class="radio-label">
                        <input type="radio" name="genre" value="M"> Masculin
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="genre" value="F"> Féminin
                    </label>
                </div>
            </div>
            <div class="form-group col-sm-12 col-md-4 col-lg-4">
                <label>Date de Naissance</label>
                <input type="date" name="date_naissance">
            </div>
            <div class="form-group col-sm-12 col-md-4 col-lg-4">
                <label>Lieu de Naissance</label>
                <select name="lieu_naissance" id="" class="selection">
                    <option value="" disabled selected>Choisir</option>
                    @foreach ($villes as $ville)
                        <option value="{{ $ville['CodeVille'] }}">{{ $ville['MonLibelle'] ?? ' ' }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </fieldset>

    <fieldset class="mt-3 p-3">
        <legend class="float-none w-auto px-2 border rounded bg-white">
            <small>Informations de Résidence et Identité</small>
        </legend>

        <div class="row">
        
            <div class="form-group col-sm-12 col-md-4 col-lg-4">
                <label>Lieu de Résidence</label>
                <select name="lieu_residence" id="" class="selection">
                    <option value="" disabled selected>Choisir</option>
                    @foreach ($villes as $ville)
                        <option value="{{ $ville['CodeVille'] }}">{{ $ville['MonLibelle'] ?? ' ' }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-sm-12 col-md-4 col-lg-4">
                <label>Situation Matrimoniale</label>
                <select name="situation_matrimoniale">
                    <option value="">Sélectionner</option>
                    <option value="CELIB">Célibataire</option>
                    <option value="MARIE">Marié(e)</option>
                    <option value="DIVOR">Divorcé(e)</option>
                    <option value="VEUVE">Veuf(ve)</option>
                    <option value="CONCUB">Concubinage</option>
                </select>
            </div>
            <div class="form-group col-sm-12 col-md-4 col-lg-4">
                <label>Type de Pièce d'Identité</label>
                <select name="type_piece_identite">
                    <option value="">Sélectionner</option>
                    <option value="CNI">CNI</option>
                    <option value="Passeport">Passeport</option>
                    <option value="Permis de conduire">Permis de conduire</option>
                    <option value="Attestation">Attestation d'identité</option>
                    <option value="carte_consulaire">Carte Consulaire</option>
                </select>
            </div>
            <div class="form-group col-sm-12 col-md-4 col-lg-4">
                <label>Numéro de Pièce</label>
                <input type="text" name="numero_piece_identite">
            </div>
            <div class="form-group col-sm-12 col-md-4 col-lg-4">
                <label>Email</label>
                <input type="email" name="email">
            </div>
            <div class="form-group col-sm-12 col-md-4 col-lg-4">
                <label>Pays</label>
                <select name="pays" id="pays" class="selection">
                    <option value="" disabled selected>Choisir ...</option>
                    @foreach ($pays as $item)
                        <option value="{{ $item['nameFr'] }}" data-code="{{ $item['code']}}">{{ $item['nameFr'] }}</option>
                    @endforeach
                </select>
                
            </div>
            <div class="form-group col-sm-12 col-md-12 col-lg-12 full-width">
                <label>Adresse Complète</label>
                <textarea name="adresse" rows="2"></textarea>
            </div>
        </div>
    </fieldset>

    <fieldset class="mt-3 p-3">
        <legend class="float-none w-auto px-2 border rounded bg-white">
            <small>Informations Professionnelles</small>
        </legend>

        <div class="row">
            <div class="form-group col-sm-12 col-md-6 col-lg-6 mb-3">
                <label>Profession</label>
                <select name="profession" id="profession" class="profession selection">

                </select>
            </div>
            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>Employeur</label>
                <input type="text" name="employeur">
            </div>
            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>Secteur d'Activité</label>
                <input type="text" name="secteur_activite">
            </div>
            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>Commerciale</label>
                <input type="text" name="reference_par"  value="{{ $commerciale->membre->nom ?? '' }} {{ $commerciale->membre->prenom ?? '' }}">
            </div>
        </div>
    </fieldset>

    <fieldset class="mt-3 p-3">
        <legend class="float-none w-auto px-2 border rounded bg-white">
            <small>Personnes Ressources</small>
        </legend>
        
        <div class="row mb-3">
            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>Personne Ressource 1</label>
                <input type="text" name="personneRessource">
            </div>
            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>Contact Ressource 1</label>
                <input type="tel" name="contactRessource">
            </div>
        </div>
        
        <div class="row">
            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>Personne Ressource 2</label>
                <input type="text" name="personneRessource2">
            </div>
            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>Contact Ressource 2</label>
                <input type="tel" name="contactRessource2">
            </div>
        </div>
    </fieldset>

    <fieldset class="mt-3 p-3">
        <legend class="float-none w-auto px-2 border rounded bg-white">
            <small>Informations Complémentaires</small>
        </legend>
        
        <div class="form-group full-width">
            <label>Notes</label>
            <textarea name="notes" rows="3" placeholder="Informations complémentaires..."></textarea>
        </div>
    </fieldset>
</div>

<h2 class="section-title" style="margin-top: 30px;">Contacts du Prospect</h2>

<div class="info-box">
    <p>📞 Ajoutez tous les numéros de téléphone et moyens de contact du prospect.</p>
</div>

<button type="button" class="btn btn-primary" onclick="openContactModal()">
    + Ajouter un Contact
</button>

<div id="contactsList" class="added-list"></div>