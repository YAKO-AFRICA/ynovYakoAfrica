<div class="form-grid">
    

    <div class="row mb-3">
        <div class="form-group col-sm-12 col-md-6 col-lg-6 mb-3">
            <label>Déjà Client YAKO AFRICA ?</label>
            <div class="radio-group">
                <label class="radio-label">
                    <input type="radio" name="dejaClient" value="oui"> Oui
                </label>
                <label class="radio-label">
                    <input type="radio" name="dejaClient" value="non"> Non
                </label>
            </div>
        </div>
        <div class="form-group col-sm-12 col-md-6 col-lg-6">
            <label>Date d'Effet</label>
            <input type="date" name="datteEffet">
        </div>
    </div>

    <div class="row">
        <div class="form-group col-sm-12 col-md-6 col-lg-6 mb-3">
            <label>Mode de Paiement</label>
            <select name="modePaiement">
                <option value="">Sélectionner</option>
                <option value="especes">Espèces</option>
                <option value="cheque">Chèque</option>
                <option value="virement">Virement bancaire</option>
                <option value="mobile_money">Mobile Money</option>
                <option value="carte">Carte bancaire</option>
            </select>
        </div>
        <div class="form-group col-sm-12 col-md-6 col-lg-6">
            <label>Périodicité de Paiement</label>
            <select name="periodicite">
                <option value="">Sélectionner</option>
                <option value="mensuel">Mensuel</option>
                <option value="trimestriel">Trimestriel</option>
                <option value="semestriel">Semestriel</option>
                <option value="annuel">Annuel</option>
            </select>
        </div>
    </div>
    
    
    
</div>
