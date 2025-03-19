<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulaire de souscription YAKO ETERNITE</title>
</head>
<body>
    <style>
        input {
            font-size: 20px;
            color: #000;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-size: 12px;
        }

        body {
            font-family: Arial, sans-serif;
            padding-left: 35px;
            padding-right: 35px;
            padding-top: 30px;
            padding-bottom: 30px;
        }

        .chechbox {
            border: 1px solid black;
            color: #fff;
            max-width: 3px !important;
            max-height: 3px !important;
            font-size: 9px;
            margin-right: 5px;
        }
    </style>

    <div class="a4-container">
        <section>
            <div class="container1_1 row" style="width: 100%">

                <div class="logo col-4" style="width: 25%; float: left">
    
                    <img src="data:image/jpg;base64,{{ base64_encode(file_get_contents(public_path('root/images/logo.png'))) }}" alt="Logo" style="width: 100px">
    
                </div>
    
                <div style="width: 75%; font-size: 12px; font-weight: bold; text-align: center; background: #747171; color: #fff; height: 55px; display: flex; justify-content: center; align-items: center; float: right">
    
                    <center class="title" style="text-align: center; align-items: center; margin-top: 15px">
    
                        <h2 class="text-uppercase" style="font-size: 15px">BULLETIN DE SOUSCRIPTION YKE</h2>
    
                    </center>
    
                </div>
    
            </div>
        </section>

        <hr>
        <section>
            <CENTER><strong>N° : YAKO AFRICA ASSURANCE-YKE-XXXXXXX</strong></CENTER>
        </section>

        <section style="width: 100%; margin-top: 15px;">
            <div style="width: 100%; text-align: center;">
                <div style="width: 33%; float: left;"><strong>Produit</strong> : Code produit</div>
                <div style="width: 33%; float: left;"><strong>Conseiller</strong> : Code conseiller/nom conseiller</div>
                <div style="width: 33%; float: left;"><strong>Agence</strong> : Code agence</div>
            </div>
            <div style="clear: both;"></div> <!-- Pour éviter les problèmes d'affichage -->
        </section>
        
        

 
        <section style="margin-top: 10px; margin-bottom: 0px; padding: 5px; border: 1px solid #ccc; font-family: Arial, sans-serif;">
            <div class="container-fluid">
        
                <!-- Titre -->
                <div class="adherent" style="border: 1px solid #ccc; background-color: #747171; height: 10px; padding: 5px;">
                    <h4 style="color: #fff; font-size: 12px; margin: 0;">ADHERENT :</h4>
                </div>
        
                <!-- Contenu -->
                <div class="content1" style="margin-top: 0px; padding: 5px; border: 1px solid #ddd;">
        
                    <!-- Colonne gauche -->
                    <div style="width: 48%; float: left;">
                        <div class="nom" style="margin-bottom: 10px;">
                            <label><strong>Nom :</strong> .........</label>
                        </div>
        
                        <div class="prenom" style="margin-bottom: 10px;">
                            <label><strong>Prénom :</strong> .......</label>
                        </div>
        
                        <div class="birthday" style="margin-bottom: 10px;">
                            <label><strong>Date de naissance :</strong> .........</label>
                        </div>
        
                        <div class="domicile" style="margin-bottom: 10px;">
                            <label><strong>Domicile :</strong> .............</label>
                        </div>
        
                        <div class="profession" style="margin-bottom: 10px;">
                            <label><strong>Profession :</strong> .............</label>
                        </div>
        
                        <div class="numeropiece" style="margin-bottom: 10px;">
                            <label><strong>CNI/Passport/Attestation :</strong> .........</label>
                        </div>
        
                        <div class="civilite" style="margin-bottom: 10px;">
                            <label><strong>Genre :</strong> ..........</label>
                        </div>
                    </div>
        
                    <!-- Colonne droite -->
                    <div style="width: 48%; float: right;">
                        <div class="lieunaissance" style="margin-bottom: 10px;">
                            <label><strong>Lieu de naissance :</strong> ..............</label>
                        </div>
        
                        <div class="postal" style="margin-bottom: 10px;">
                            <label><strong>Boîte Postale :</strong> ------------</label>
                        </div>
        
                        <div class="employeur" style="margin-bottom: 10px;">
                            <label><strong>Employeur :</strong> ................</label>
                        </div>
        
                        <div class="telephone" style="margin-bottom: 10px;">
                            <label><strong>Téléphone / Cell :</strong> .......</label>
                        </div>
        
                        <div class="situation" style="margin-bottom: 10px;">
                            <label><strong>Situation Matrimoniale :</strong></label>
                            <div>
                                <span>Célibataire <span class="checkbox">☐</span></span>
                                <span>Marié(e) <span class="checkbox">☐</span></span>
                                <span>Veuf(ve) <span class="checkbox">☐</span></span>
                            </div>
                        </div>
                    </div>
        
                    <!-- Clear pour éviter les flottements -->
                    <div style="clear: both;"></div>
        
                </div>
        
            </div>
        </section>
        
        

        <section>

            <div class="aderent" style="margin-top: 10px; border: 1px solid #ccc; background-color: #747171; height: 18px">
    
                <h3 style="color: #fff; font-size: 13px; margin-left: 5px">2. ASSURES </h3>

            </div>
    
            <div class="content1">
    
                <table border="1" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <th>Nom</th>
                        <th>Filiation</th>
                        <th>Né(e) le</th>
                        <th>Lieu naissance</th>
                        <th>Résidence</th>
                    </tr>
                    <tr>
                        <td>Dupont</td>
                        <td>Fils de Jean Dupont</td>
                        <td>01/01/1990</td>
                        <td>Paris</td>
                        <td>Lyon</td>
                    </tr>
                    <tr>
                        <td>Durand</td>
                        <td>Fils de Marie Durand</td>
                        <td>12/05/1985</td>
                        <td>Marseille</td>
                        <td>Bordeaux</td>
                    </tr>
                </table>
                
                
            </div>
        </section>
        <section>

            <div class="aderent" style="margin-top: 10px; border: 1px solid #ccc; background-color: #747171; height: 18px">
    
                <h3 style="color: #fff; font-size: 13px; margin-left: 5px">2. BENEFICIAIRES </h3>

            </div>
    
            <div class="content1">
                <div class="identiteee" style="width: 100%">
    
                    <div style="width: 50%; min-height: 60px; float: left; border: 1px solid #000; padding: 5px; display: flex; justify-content: space-between; align-items: center;">
                        <div class="terme" style="flex: 1;">
                            <u>Au terme du contrat</u>
                        </div>

                        <div class="prenom" style="flex: 1; width: 100%; text-align: left; margin-top: 10px; text-transform: capitalize">
                           ...............
                        </div>
                
                    </div>
                
                    <div style="width: 50%; min-height: 60px; float: right; border: 1px solid #000; padding: 5px; display: flex; justify-content: space-between; align-items: center;">
                        <div class="terme" style=" flex: 1;">
                            <u>En cas de décès avant terme du contrat</u>
                        </div>
                
                        <div class="prenom" style="flex: 1; width: 100%; text-align: left; margin-top: 10px; text-transform: capitalize">
                            ................
                        </div>
                
                        
                    </div>
                
                </div>
    
                <table border="1" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <th>Nom</th>
                        <th>Filiation</th>
                        <th>Né(e) le</th>
                        <th>Lieu naissance</th>
                        <th>Telephone</th>
                    </tr>
                    <tr>
                        <td>Dupont</td>
                        <td>Fils de Jean Dupont</td>
                        <td>01/01/1990</td>
                        <td>Paris</td>
                        <td>01111111</td>
                    </tr>
                </table>
                
                
            </div>
        </section>


        <section style="margin-top: 20px; padding: 5px; border: 1px solid #ccc; font-family: Arial, sans-serif;">
            <div class="container">
        
                <!-- Titre de la section -->
                <div class="adherent" style="margin-top: 5px; border: 1px solid #ccc; background-color: #747171; height: 25px; display: flex; align-items: center; padding-left: 10px;">
                    <h4 style="color: #fff; font-size: 14px; margin: 0;">3. GARANTIE & PRIMES :</h4>
                </div>
        
                <!-- Contenu avec le tableau -->
                <div class="content1" style="margin-top: 10px; padding: 10px; border: 1px solid #ddd;">
        
                    <table border="1" cellpadding="5" cellspacing="0" width="100%" style="border-collapse: collapse;">
                        <thead style="background-color: #f2f2f2;">
                            <tr>
                                <th style="text-align: left; padding: 8px;">Garantie</th>
                                <th style="text-align: center; padding: 8px;">Option/Capital</th>
                                <th style="text-align: center; padding: 8px;">Prime</th>
                                <th style="text-align: center; padding: 8px;">Périodicité</th>
                                <th style="text-align: center; padding: 8px;">Total Primes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 8px;">Hommage</td>
                                <td style="text-align: center; padding: 8px;">3000</td>
                                <td style="text-align: center; padding: 8px;">380000</td>
                                <td style="text-align: center; padding: 8px;">Semestre</td>
                                <td style="text-align: center; padding: 8px;">34200</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px;">Hommage</td>
                                <td style="text-align: center; padding: 8px;">3000</td>
                                <td style="text-align: center; padding: 8px;">380000</td>
                                <td style="text-align: center; padding: 8px;">Semestre</td>
                                <td style="text-align: center; padding: 8px;">34200</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr style="background-color: #e0e0e0; font-weight: bold;">
                                <td colspan="4" style="text-align: right; padding: 8px;">TOTAL PRIME :</td>
                                <td style="text-align: center; padding: 8px;">68400</td>
                            </tr>
                            <div class="content1">
    
                                <table border="1" cellpadding="5" cellspacing="0" width="100%">
                                    <tr>
                                        <th>Capital souscrit</th>
                                        <th>Date effet</th>
                                        <th>Duré</th>
                                        <th>Echeance</th>
                                    </tr>
                                    <tr>
                                        <td>500 000</td>
                                        <td>01/02/2000</td>
                                        <td>5</td>
                                        <td>01/10/2000</td>
                                    </tr>
                                </table>
                                
                            </div>
                        </tfoot>
                    </table>
        
                </div>
        
            </div>
        </section>
        <section style="margin-top: 20px; padding: 5px; border: 1px solid #ccc; font-family: Arial, sans-serif;">
            <div class="container">
        
                <!-- Titre de la section -->
                <div class="adherent" style="margin-top: 5px; border: 1px solid #ccc; background-color: #747171; height: 25px; display: flex; align-items: center; padding-left: 10px;">
                    <h4 style="color: #fff; font-size: 14px; margin: 0;">4. PAIEMENT DES PRIMES :</h4>
                </div>
        
                <!-- Contenu avec le tableau -->
                <div class="content1" style="margin-top: 5px; padding: 5px; border: 1px solid #ddd;">
        
                    <table border="1" cellpadding="5" cellspacing="0" width="100%" style="border-collapse: collapse;">
                        <thead style="background-color: #f2f2f2;">
                            <tr>
                                <th style="text-align: left; padding: 8px;">Mode de paiement</th>
                                <th style="text-align: center; padding: 8px;">Agence</th>
                                <th style="text-align: center; padding: 8px;">Organisme</th>
                                <th style="text-align: center; padding: 8px;">N° Compte</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 8px;">Hommage</td>
                                <td style="text-align: center; padding: 8px;">3000</td>
                                <td style="text-align: center; padding: 8px;">380000</td>
                                <td style="text-align: center; padding: 8px;">Semestre</td>
                            </tr>
                        </tbody>
                    </table>
        
                </div>
        
            </div>
        </section>


        <section style="margin-top: 30px">
            <div class="identiteee" style="width: 100%">
                <div style="width: 48%; float: left; border: 1px solid #000; padding: 5px; display: flex; justify-content: space-between; align-items: center;">

                    <div class="sign-yako">

                        <span>Reservé à YAKO AFRICA Assurances Vie</span>
                        <div>
                            <img src="data:image/jpg;base64,{{ base64_encode(file_get_contents(public_path('root/images/Signature_Dta.jpg'))) }}" alt="Logo" style="width: 200px">
                        </div>
                    </div>

                </div>

                <div style="width: 48%; min-height: 127px; float: right; border: 1px solid #000; padding: 5px; display: flex; justify-content: space-between; align-items: center;">

                    <div class="nom">

                        <label for="nom"><strong>Nom du conseiller :</strong> {{ Auth::user()->membre->nom ?? ""}} {{ Auth::user()->membre->prenom ?? ""}}</label>

                        <br><br>

                        <label for="prenom">Signature du Souscripteur</label>

                    </div>

                </div>
            </div>
        </section>

       

    </div>

</body>

</html>

