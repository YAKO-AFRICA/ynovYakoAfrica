<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Formulaire de Souscription – YAKO ASSURANCE VIE</title>
<style>
  /* CSS 2 compatible - DOMPDF - Version sans débordement */
  * {
    margin: 0;
    padding: 0;
  }

  body {
    background: white;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 11px;
    color: #1e1e1e;
    padding: 5px;
    margin: 0;
  }

  .page {
    background: white;
    max-width: 900px !important;
    /* width: 210mm; */
    margin: 0 auto;
    padding: 5mm 5mm 10mm 8mm;
    border-top: 6px solid #076633;
  }

  /* ── HEADER ── */
  .header-table {
    width: 100%;
    border-collapse: collapse;
    border-bottom: 2px solid #076633;
    margin-bottom: 5px;
  }

  .brand h1 {
    font-family: 'Times New Roman', serif;
    font-size: 20pt;
    color: #076633;
  }

  .brand p {
    font-size: 7pt;
    color: #8b1a1a;
    letter-spacing: 1px;
    text-transform: uppercase;
  }

  .form-title {
    font-family: 'Times New Roman', serif;
    font-size: 18pt;
    color: #076633;
  }

  .numero-bloc {
    margin-top: 5px;
    background: #076633;
    color: #fff;
    font-size: 7pt;
    padding: 3px 6px;
    text-align: center;
    font-weight: 700;
  }

  /* ── SECTION ── */
  .section {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 6px;
    border: 1px solid #c8bfa8;
    background: white;
  }

  .section-header {
    background: #076633;
    color: #fff;
    font-family: 'Times New Roman', serif;
    font-size: 9pt;
    padding: 3px 8px;
    text-align: left;
    font-weight: bold;
  }

  .section-body {
    padding: 6px 8px;
  }

  /* ── FORM TABLE ── */
  .form-table {
    width: 100%;
    border-collapse: collapse;
  }

  .form-table td {
    padding: 3px 5px 3px 0;
    vertical-align: top;
  }

  .form-table label {
    font-size: 7pt;
    color: #555;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    display: block;
  }

  .form-line {
    border-bottom: 1px solid #c8bfa8;
    min-height: 16px;
  }

  /* ── CHECKBOXES ── */
  .cb-box {
    width: 8px;
    height: 8px;
    border: 1px solid #076633;
    display: inline-block;
    background: white;
    margin-right: 3px;
    
  }

  .cb-label {
    font-size: 9pt;
    margin-right: 10px;
  }

  .sexe-group {
    white-space: nowrap;
    margin-top: 2px;
  }

  /* ── PATHOLOGIE ── */
  .patho-table {
    width: 100%;
    border-collapse: collapse;
    margin: 4px 0;
  }

  .patho-table td {
    padding: 3px 5px 3px 0;
  }

  /* ── COUVERTURE TABLE ── */
  .cov-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 10px;
  }

  .cov-table td {
    padding: 4px 5px;
    border-bottom: 1px solid #c8bfa8;
  }

  .cov-table tr:last-child td {
    border-bottom: none;
  }

  .cov-table .lbl {
    color: #555;
    font-weight: 600;
  }

  .cov-table .val {
    text-align: right;
    font-weight: 700;
    color: #8b1a1a;
  }

  .cov-table tr.total-row td {
    background: #076633;
    color: #d4a843;
    font-weight: 700;
  }

  .field-line {
    border-bottom: 1px dashed #c8bfa8;
    display: inline-block;
    width: 60px;
    height: 14px;
  }

  /* ── MODALITÉ ── */
  .modalite-bar {
    background: #076633;
    padding: 2px;
    margin-top: 3px;
    margin-bottom: 3px;
  }

  .modalite-bar table {
    width: 100%;
  }

  .modalite-bar td {
    color: white;
    padding-right: 15px;
  }

  .modalite-bar .lbl {
    color: #fff;
    font-size: 8pt;
    font-weight: 600;
    text-transform: uppercase;
  }

  /* ── ENFANTS TABLE ── */
  .enf-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 9px;
  }

  .enf-table th {
    background: #076633;
    color: #d4a843;
    padding: 3px 5px;
    text-align: left;
    font-weight: 600;
    font-size: 7pt;
    text-transform: uppercase;
  }

  .enf-table td {
    border-bottom: 1px solid #c8bfa8;
    padding: 4px 5px;
  }

  .enf-table .num-cell {
    color: #076633;
    font-weight: 700;
    text-align: center;
    width: 20px;
  }

  /* ── LISTE PAIEMENT ── */
  .paiement-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .paiement-list li {
    padding: 4px 0;
    border-bottom: 1px dashed #c8bfa8;
    font-size: 9px;
  }

  .paiement-list li:last-child {
    border-bottom: none;
  }

  /* ── SIGNATURES ── */
  .sig-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 6px;
  }

  .sig-table td {
    width: 48%;
    border: 1px solid #c8bfa8;
    padding: 6px 8px;
    vertical-align: top;
    background: white;
  }

  .sig-title {
    font-size: 8pt;
    font-weight: 700;
    text-transform: uppercase;
    color: #8b1a1a;
    margin-bottom: 6px;
  }

  .sig-consent {
    font-size: 7pt;
    color: #666;
    line-height: 1.3;
    font-style: italic;
    margin-bottom: 15px;
  }

  .lu-approuve {
    font-size: 6.5pt;
    color: #888;
    font-style: italic;
  }

  /* ── EXCLUSIONS ── */
  .exclusions {
    font-size: 7.5pt;
    color: #666;
    border-left: 3px solid #076633;
    padding-left: 6px;
    margin-bottom: 6px;
    font-style: italic;
  }

  .exclusions strong {
    color: #8b1a1a;
    font-style: normal;
  }

  /* ── DIVIDER ── */
  .gold-divider {
    height: 2px;
    background: #076633;
    margin: 4px 0 6px;
  }

  .small-text {
    font-size: 6.5pt;
    color: #777;
    font-style: italic;
    margin-top: 4px;
    border-top: 1px dashed #c8bfa8;
    padding-top: 3px;
  }

  .qr-box {
    width: 45px;
    height: 45px;
    border: 1.5px dashed #c8bfa8;
    margin: 3px auto 0;
    text-align: center;
    line-height: 45px;
    font-size: 6pt;
    color: #aaa;
  }

  .qr-zone {
    text-align: center;
    font-size: 6.5pt;
    color: #888;
    font-style: italic;
  }

  .text-right {
    text-align: right;
  }

  .inline-line {
    border-bottom: 1px dotted #c8bfa8;
    display: inline-block;
    width: 100px;
    height: 14px;
  }

  .short-line {
    border-bottom: 1px dotted #c8bfa8;
    display: inline-block;
    width: 60px;
    height: 14px;
  }

  /* Marges réduites */
  .no-margin {
    margin: 0;
  }

  .p-small {
    margin-bottom: 3px;
  }
</style>
</head>
<body>

<div class="page">

  <!-- HEADER -->
  <table class="header-table">
    <tr><td style="width:25%;">
      <div class="brand">
        <img src="data:image/jpg;base64,{{ base64_encode(file_get_contents(public_path('root/images/logo.png'))) }}" alt="Logo" style="width: 70px; margin-bottom: 10px">
      </div>
    </td>
    <td style="width:50%; text-align:center;">
      <div class="form-title">Formulaire de Souscription</div>
    </td>
    <td style="width:25%; text-align:right;">
      <div class="numero-bloc">N° : <span class="short-line"></span> / <span class="short-line"></span></div>
    </td>
    </tr>
  </table>

  <!-- SECTION 1 -->
  <table class="section">
    <tr><td class="section-header">1. Informations du Souscripteur / Adhérent / Assuré — Option : Individuel</td></tr>
    <tr><td class="section-body">
      <table class="form-table">
        <tr><td colspan="3"><label>Nom et Prénom</label><div class="form-line">_________________________</div></td></tr>
        <tr>
          <td width="25%"><label>Date de naissance</label><div class="form-line">____________</div></td>
          <td width="25%"><label>Lieu de naissance</label><div class="form-line">____________</div></td>
          <td width="25%"><label>Nationalité</label><div class="form-line">____________</div></td>
          <td width="25%">
            <label>Sexe</label>
            <div class="sexe-group">
              <span class="cb-label"><span class="cb-box"></span> M</span>
              <span class="cb-label"><span class="cb-box"></span> F</span>
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="2"><label>Fonction</label><div class="form-line">____________</div></td>
          <td><label>Type de pièce</label><div class="form-line">____________</div></td>
          <td><label>N° de pièce</label><div class="form-line">____________</div></td>
        </tr>
        <tr><td colspan="4"><label>Adresse complète</label><div class="form-line">_________________________________</div></td></tr>
        <tr>
          <td><label>Tél 1</label><div class="form-line">____________</div></td>
          <td><label>Tél 2</label><div class="form-line">____________</div></td>
          <td><label>WhatsApp</label><div class="form-line">____________</div></td>
          <td><label>E-mail</label><div class="form-line">__________________</div></td>
        </tr>
      </table>
    </td></tr>
  </table>

  <!-- SECTIONS 2 + 3 côte à côte -->
  <table style="width:100%; border-collapse:collapse;">
    <tr>
      <td width="55%" style="padding-right:4px; vertical-align:top;">
        <table class="section" style="margin-bottom:0;">
          <tr><td class="section-header">2. Déclaration de Santé « Assuré »</td></tr>
          <tr><td class="section-body">
            <div style="margin-bottom:5px;">
              <span class="cb-label"><span class="cb-box"></span> L'assuré déclare être en bonne santé.</span>
            </div>
            <p style="font-size:9px; margin-bottom:3px;">L'assuré souffre-t-il de :</p>

            <table class="patho-table">
              <tr><td>Diabète <span class="cb-box"></span> Oui <span class="cb-box"></span> Non</td><td>AVC <span class="cb-box"></span> Oui <span class="cb-box"></span> Non</td></tr>
              <tr><td>Cancer <span class="cb-box"></span> Oui <span class="cb-box"></span> Non</td><td>Insuff. Rénale <span class="cb-box"></span> Oui <span class="cb-box"></span> Non</td></tr>
              <tr><td colspan="2">Hypertension <span class="cb-box"></span> Oui <span class="cb-box"></span> Non</td></tr>
            </table>

            <p class="small-text">Chaque pathologie « Oui » = surprime <strong>5 500 FCFA</strong></p>
          </td></tr>
        </table>
      </td>

      <td width="45%" style="padding-left:4px; vertical-align:top;">
        <table class="section" style="margin-bottom:0;">
            <tr>
                <td class="section-header">3. Couverture Souhaitée</td>
            </tr>
            <tr>
                <td class="section-body">
                    <table class="cov-table">
                        <tr>
                            <td class="lbl">Choix Capital</td>
                            <td class="val">
                                <span class="field-line"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="lbl">Prime Periodique</td>
                            <td class="val">
                                <span class="field-line"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="lbl">Surprime</td>
                            <td class="val">
                                <span class="field-line"></span>
                            </td>
                        </tr>
                        <tr class="total-row">
                            <td class="lbl">Total Prime</td>
                            <td class="val">
                                <span class="field-line"></span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
      </td>
    </tr>
  </table>

  <!-- MODALITÉ -->
  <div class="modalite-bar">
    <table>
      <tr>
        <td class="lbl">Modalité de paiement : 
            <span class="cb-label" style="color:white; font-size: 9px;"><span class="cb-box" ></span> Annuel</span>
            <span class="cb-label" style="color:white; font-size: 9px;"><span class="cb-box" ></span> Mensuel</span>
        </td>
        <td class="lbl">Durée : <span>1 an</span></td>
        <td class="lbl">Debut de contrat : <span class="field-line"></span></td>
      </tr>
      
    </table>
  </div>

  <!-- EXCLUSIONS -->
  {{-- <div class="exclusions">
    <strong>Exclusions :</strong> Suicide, guerre, actes criminels, drogues et alcool, accidents dangereux, terrorisme, maladies mentales, naufrages, radiations, catastrophes naturelles, conflits militaires.
  </div> --}}

  <!-- BÉNÉFICIAIRES -->
  <table style="width:100%; border-collapse:collapse;">
    <tr>
      <td width="50%" style="padding-right:3px; vertical-align:top;">
        <table class="section" style="margin-bottom:0;">
          <tr><td class="section-header">4. Bénéficiaire Désigné</td></tr>
          <tr><td class="section-body">
            <table class="form-table">
              <tr><td><label>Nom et Prénoms</label><div class="form-line">____________________</div></td></tr>
              <tr><td><label>Lien avec l'adhérent</label><div class="form-line">____________________</div></td></tr>
              <tr><td><label>Téléphone</label><div class="form-line">____________________</div></td></tr>
              <tr><td><label>Adresse</label><div class="form-line">____________________</div></td></tr>
            </table>
          </td></tr>
        </table>
      </td>
      <td width="50%" style="padding-left:3px; vertical-align:top;">
        <table class="section" style="margin-bottom:0;">
          <tr><td class="section-header">5. Bénéficiaire par défaut</td></tr>
          <tr><td class="section-body">
            <table class="form-table">
              <tr><td><label>Nom et Prénoms</label><div class="form-line">Fond du Trésor Public</div></td></tr>
              <tr><td><label>Lien avec l'adhérent</label><div class="form-line">Employeur</div></td></tr>
              <tr><td><label>Téléphone</label><div class="form-line">____________________</div></td></tr>
              <tr><td><label>Adresse</label><div class="form-line">____________________</div></td></tr>
            </table>
          </td></tr>
        </table>
      </td>
    </tr>
  </table>

  <!-- ENFANTS -->
  <table class="section" style="margin-top:6px;">
    <tr><td class="section-header">6. Enfants Scolarisés (Maximum 5)</td></tr>
    <tr><td class="section-body">
      <table style="width:100%;">
        <tr>
          <td width="85%">
            <table class="enf-table">
              <thead><tr><th>N°</th><th>Nom et Prénoms</th><th>Date naissance</th><th>Niveau</th><th>Observations</th></tr></thead>
              <tbody>
                <tr><td class="num-cell">1</td><td>_________</td><td>_________</td><td>_________</td><td>_________</td></tr>
                <tr><td class="num-cell">2</td><td>_________</td><td>_________</td><td>_________</td><td>_________</td></tr>
                <tr><td class="num-cell">3</td><td>_________</td><td>_________</td><td>_________</td><td>_________</td></tr>
                <tr><td class="num-cell">4</td><td>_________</td><td>_________</td><td>_________</td><td>_________</td></tr>
                <tr><td class="num-cell">5</td><td>_________</td><td>_________</td><td>_________</td><td>_________</td></tr>
              </tbody>
            </table>
          </td>
          <td width="15%">
            <div class="qr-zone">
              <small>Merci de partager ton Expérience-client via ce QR code</small>
              <div class="qr-bo">
                <img src="data:image/jpg;base64,{{ base64_encode(file_get_contents(public_path('root/images/qrCodeAsaci.png'))) }}" alt="qrCode" style="width: 70px; margin-bottom: 10px">
              </div>
            </div>
          </td>
        </tr>
      </table>
    </td></tr>
  </table>

  <!-- PAIEMENT -->
  <table class="section">
    <tr><td class="section-header">Paiement des Primes</td></tr>
    <tr><td class="section-body">
      <p style="font-size:9px; margin-bottom:4px;">Le montant total des primes est payé par :</p>
      <ul class="paiement-list">
        <li><span class="cb-box"></span> Prélèvement bancaire <span style="font-size:8px; color:#999;">(RIB + attestation)</span></li>
        <li><span class="cb-box"></span> Retenue sur salaire <span style="font-size:8px; color:#999;">(autorisation employeur)</span></li>
        <li><span class="cb-box"></span> Chèque (ordre YAKO ASSURANCE VIE)</li>
        <li><span class="cb-box"></span> Autres : <span class="inline-line" style="width:150px;"></span></li>
      </ul>
    </td></tr>
  </table>

  <!-- FAIT À + CONSEILLER -->
  <table style="width:100%; margin:6px 0;">
    <tr>
      <td style="text-align:left;">
        Fait à : <span class="inline-line" style="width:100px;"></span>
        &nbsp;&nbsp; Le : <span class="inline-line" style="width:100px;"></span>
      </td>
      <td style="text-align:right;">
        <div>
            <strong>Conseiller :</strong> <span class="inline-line" style="width:200px;"></span>
        </div>
        
      </td>
      <td>
        <div style="margin-top:3px;"><strong>Code :</strong> <span class="inline-line" style="width:80px;"></span></div>
      </td>
    </tr>
  </table>

  <div class="gold-divider"></div>

  <!-- SIGNATURES -->
  <table class="sig-table">
    <tr>
      <td>
        <div class="sig-title">Signature du Souscripteur</div>
        <div class="sig-consent">Je soussigné(e), ____________________, certifie l'exactitude des informations. Je consens au traitement de mes données.</div>
        <div class="lu-approuve">(Précédée de LU ET APPROUVÉ)</div>
      </td>
      <td>
        <div class="sig-title">Signature de l'Assuré</div>
        <div class="lu-approuve" style="margin-top:35px;">(Précédée de LU ET APPROUVÉ)</div>
      </td>
    </tr>
  </table>

</div>

</body>
</html>