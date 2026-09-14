<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulation Frais Funéraires</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* ===== RESET & BASE ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #ccc;
            padding: 18px;
            min-height: 100vh;
        }

        .container {
            max-width: 1300px;
            margin: 0 auto;
        }

        /* ===== HEADER ===== */
        .header {
            text-align: center;
            padding: 24px 20px 18px;
            background: linear-gradient(135deg, #076633, #043a1d);
            border-radius: 16px;
            margin-bottom: 24px;
            color: white;
            box-shadow: 0 8px 30px rgba(26, 42, 108, 0.3);
        }

        .header h1 {
            font-size: 1.7rem;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .header h1 i {
            margin-right: 10px;
        }

        .header p {
            font-size: 0.92rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        /* ===== GRILLE ===== */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 18px;
            margin-top: 16px;
        }

        /* ===== CARTE ===== */
        .card {
            background: white;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.07);
            transition: transform 0.25s, box-shadow 0.25s;
            border: 2px solid transparent;
            font-size: 0.85rem;
            animation: fadeInUp 0.5s ease forwards;
            display: flex;
            flex-direction: column;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.10);
        }

        .card.recommended {
            border-color: #f6b83d;
            position: relative;
        }

        .card.recommended::before {
            content: '⭐ RECOMMANDÉ';
            position: absolute;
            top: 6px;
            right: 10px;
            background: #f6b83d;
            color: #1a2a6c;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 0.4px;
            z-index: 2;
        }

        /* ===== COULEURS PAR FORMULE ===== */
        .card-complete .card-header {
            background: linear-gradient(135deg, #1a2a6c, #2d4373);
        }
        .card-complete .btn-select {
            background: linear-gradient(135deg, #1a2a6c, #2d4373);
        }
        .card-complete .total-amount,
        .card-complete .guarantees-table .value.highlight {
            color: #1a2a6c;
        }
        .card-complete .card-total {
            border-top-color: #c7cfe6;
        }

        .card-premium .card-header {
            background: linear-gradient(135deg, #f68615, #a75706);
        }
        .card-premium .btn-select {
            background: linear-gradient(135deg, #f68615, #a75706);
        }
        .card-premium .total-amount,
        .card-premium .guarantees-table .value.highlight {
            color: #f68615;
        }
        .card-premium .card-total {
            border-top-color: #e3c9f0;
        }
        .card-premium .card-detail-trigger {
            color: #f68615;
        }
        .card-premium .card-detail-content ul li i,
        .card-premium .card-detail-content ul li strong {
            color: #f68615;
        }

        .card-economique .card-header {
            background: linear-gradient(135deg, #1a5a3c, #2d7a5a);
        }
        .card-economique .btn-select {
            background: linear-gradient(135deg, #1a5a3c, #2d7a5a);
        }
        .card-economique .total-amount,
        .card-economique .guarantees-table .value.highlight {
            color: #1a5a3c;
        }
        .card-economique .card-total {
            border-top-color: #bfe0cd;
        }
        .card-economique .card-detail-trigger {
            color: #1a5a3c;
        }
        .card-economique .card-detail-content ul li i,
        .card-economique .card-detail-content ul li strong {
            color: #1a5a3c;
        }

        /* ===== HEADER DE LA CARTE ===== */
        .card-header {
            padding: 14px 16px 12px;
            color: white;
            text-align: center;
            flex-shrink: 0;
        }

        .card-header .option-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 2px 12px;
            border-radius: 20px;
            font-size: 0.6rem;
            font-weight: 600;
            letter-spacing: 0.8px;
            margin-bottom: 4px;
        }

        .card-header h3 {
            font-size: 1.1rem;
            font-weight: 700;
        }

        .card-header .price {
            margin-top: 8px;
            display: flex;
            justify-content: center;
            gap: 18px;
            flex-wrap: wrap;
        }

        .card-header .price-item {
            text-align: center;
        }

        .card-header .price-item .amount {
            font-size: 1.05rem;
            font-weight: 700;
        }

        .card-header .price-item .label {
            font-size: 0.6rem;
            opacity: 0.8;
            display: block;
            margin-top: 1px;
        }

        /* ===== CORPS DE LA CARTE ===== */
        .card-body {
            padding: 12px 14px 8px;
            flex: 1;
        }

        .guarantees-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8rem;
        }

        .guarantees-table tr {
            border-bottom: 1px solid #f0f4f8;
        }

        .guarantees-table tr:last-child {
            border-bottom: none;
        }

        .guarantees-table td {
            padding: 5px 4px;
        }

        .guarantees-table .category {
            font-weight: 600;
            color: #333;
        }

        .guarantees-table .value {
            text-align: right;
            font-weight: 500;
        }

        .guarantees-table .value.highlight {
            font-weight: 700;
        }

        .guarantees-table .note-row td {
            font-size: 0.65rem;
            color: #888;
            font-style: italic;
            padding-top: 2px;
        }

        /* ===== DÉTAIL (accordéon) ===== */
        .card-detail {
            padding: 0 14px 12px;
            border-top: 2px dashed #e2e8f0;
            margin-top: 4px;
            flex-shrink: 0;
        }

        .card-detail-trigger {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            padding: 6px 10px;
            background: #f8fafc;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.75rem;
            cursor: pointer;
            transition: background 0.25s;
            margin-top: 4px;
        }

        .card-detail-trigger:hover {
            background: #e2e8f0;
        }

        .card-detail-trigger i {
            transition: transform 0.3s;
        }

        .card-detail-trigger.active i {
            transform: rotate(180deg);
        }

        .card-detail-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease, padding 0.25s ease;
            padding: 0 2px;
        }

        .card-detail-content.open {
            max-height: 600px;
            padding: 10px 2px 2px;
        }

        .card-detail-content ul {
            list-style: none;
            padding: 0;
        }

        .card-detail-content ul li {
            padding: 4px 0 4px 24px;
            position: relative;
            font-size: 0.75rem;
            color: #444;
            border-bottom: 1px solid #f0f4f8;
        }

        .card-detail-content ul li:last-child {
            border-bottom: none;
        }

        .card-detail-content ul li i {
            position: absolute;
            left: 0;
            top: 5px;
            width: 16px;
            text-align: center;
            font-size: 0.7rem;
        }

        /* ===== TOTAL EN BAS ===== */
        .card-total {
            background: #f8fafc;
            padding: 10px 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            border-top: 2px solid #e2e8f0;
            flex-shrink: 0;
        }

        .card-total .total-label {
            font-weight: 600;
            font-size: 0.75rem;
            color: #555;
        }

        .card-total .total-amount {
            font-size: 0.95rem;
            font-weight: 700;
        }

        .card-total .total-amount span {
            font-weight: 400;
            font-size: 0.65rem;
            color: #666;
        }

        .btn-select {
            color: white;
            border: none;
            padding: 7px 18px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.78rem;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            flex-shrink: 0;
        }

        .btn-select:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.18);
        }

        .btn-select.outline {
            background: transparent !important;
            color: #1a5a3c;
            border: 2px solid #1a5a3c;
        }

        .btn-select.outline:hover {
            background: #1a5a3c !important;
            color: white;
        }

        /* ===== BANDEAU INFO ===== */
        .info-banner {
            margin-top: 20px;
            background: #fff8e6;
            border: 1px solid #f6b83d;
            border-radius: 10px;
            padding: 10px 16px;
            font-size: 0.8rem;
            color: #5c4a10;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-banner i {
            color: #f6b83d;
            font-size: 1rem;
        }

        /* ===== COMPARATIF ===== */
        .comparatif {
            margin-top: 24px;
            background: white;
            border-radius: 12px;
            padding: 16px 18px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.07);
            overflow-x: auto;
        }

        .comparatif h3 {
            color: #1a2a6c;
            margin-bottom: 10px;
            font-size: 0.95rem;
        }

        .comparatif table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8rem;
            min-width: 420px;
        }

        .comparatif thead tr {
            background: #f0f4f8;
        }

        .comparatif th,
        .comparatif td {
            padding: 8px 10px;
            text-align: left;
        }

        .comparatif th {
            text-align: center;
        }

        .comparatif td {
            text-align: center;
        }

        .comparatif td:first-child {
            text-align: left;
            font-weight: 600;
        }

        .comparatif tr {
            border-bottom: 1px solid #e2e8f0;
        }

        .comparatif tr:last-child {
            border-bottom: none;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .header h1 {
                font-size: 1.3rem;
            }

            .cards-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .card-total {
                flex-direction: column;
                text-align: center;
            }

            .btn-select {
                width: 100%;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .header {
                padding: 16px 10px 14px;
            }

            .header h1 {
                font-size: 1.1rem;
            }

            .card-header {
                padding: 12px;
            }

            .card-body {
                padding: 10px;
            }
        }

        /* ===== ANIMATION ===== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card:nth-child(2) {
            animation-delay: 0.08s;
        }
        .card:nth-child(3) {
            animation-delay: 0.16s;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f0f4f8;
        }
        ::-webkit-scrollbar-thumb {
            background: #1a2a6c;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- HEADER -->
        <div class="header">
            <h1><i class="fas fa-hand-holding-heart"></i> Simulation Frais Funéraires</h1>
            <p>Choisissez la formule qui correspond le mieux à vos besoins</p>
        </div>

        <!-- GRILLE DES CARTES -->
        <div class="cards-grid" id="cardsGrid">
            <!-- OPTION 1 - COMPLÈTE -->
            <div class="card card-complete recommended" data-formule="complete" data-prime="9672" data-capital="10000000">
                <div class="card-header">
                    <div class="option-badge">FORMULE COMPLÈTE</div>
                    <h3>OPTION 1</h3>
                    <div class="price">
                        <div class="price-item">
                            <div class="amount">9 672 CFA</div>
                            <span class="label">/ Mois</span>
                        </div>
                        <div class="price-item">
                            <div class="amount">116 064 CFA</div>
                            <span class="label">/ An</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="guarantees-table">
                        <tr><td class="category">👤 Adhérent</td><td class="value highlight">2 000 000 CFA</td></tr>
                        <tr><td class="category">👩 Conjoint(e)</td><td class="value highlight">2 000 000 CFA</td></tr>
                        <tr><td class="category">👶 Enfants (jusqu'à 4)</td><td class="value">1 000 000 CFA /👶</td></tr>
                        <tr><td class="category">👴 Ascendants (x2)</td><td class="value">2 000 000 CFA /👴</td></tr>
                        <tr class="note-row"><td colspan="2">+680 CFA/mois par enfant dès le 5ᵉ</td></tr>
                    </table>
                </div>
                <div class="card-detail">
                    <button class="card-detail-trigger" onclick="toggleDetail(this)">
                        <i class="fas fa-chevron-down"></i> Voir les détails
                    </button>
                    <div class="card-detail-content">
                        <ul>
                            <li><i class="fas fa-check-circle"></i> <strong>Couverture totale :</strong> 10 000 000 CFA</li>
                            <li><i class="fas fa-check-circle"></i> <strong>Bénéficiaires :</strong> Adhérent + Conjoint + Enfants (4 max) + 2 Ascendants</li>
                            <li><i class="fas fa-check-circle"></i> <strong>5ᵉ enfant :</strong> +680 CFA/mois par enfant supplémentaire</li>
                            <li><i class="fas fa-check-circle"></i> <strong>Délai de carence :</strong> 3 mois</li>
                            <li><i class="fas fa-check-circle"></i> <strong>Validité :</strong> 12 mois renouvelable</li>
                            <li><i class="fas fa-check-circle"></i> <strong>Assistance premium :</strong> Rapatriement inclus</li>
                        </ul>
                    </div>
                </div>
                <div class="card-total">
                    <div>
                        <span class="total-label">Total garanti</span>
                        <div class="total-amount">10 000 000 CFA <span>(2 ascendants)</span></div>
                    </div>
                    <button class="btn-select" onclick="selectOption(this)">Choisir</button>
                </div>
            </div>

            <!-- OPTION 2 - PREMIUM -->
            <div class="card card-premium" data-formule="premium" data-prime="7652" data-capital="9000000">
                <div class="card-header">
                    <div class="option-badge">FORMULE PREMIUM</div>
                    <h3>OPTION 2</h3>
                    <div class="price">
                        <div class="price-item">
                            <div class="amount">7 652 CFA</div>
                            <span class="label">/ Mois</span>
                        </div>
                        <div class="price-item">
                            <div class="amount">91 824 CFA</div>
                            <span class="label">/ An</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="guarantees-table">
                        <tr><td class="category">👤 Adhérent</td><td class="value highlight">2 000 000 CFA</td></tr>
                        <tr><td class="category">👩 Conjoint(e)</td><td class="value highlight">2 000 000 CFA</td></tr>
                        <tr><td class="category">👶 Enfants (jusqu'à 4)</td><td class="value">1 000 000 CFA /👶</td></tr>
                        <tr><td class="category">👴 Ascendant (x1)</td><td class="value">1 000 000 CFA</td></tr>
                        <tr class="note-row"><td colspan="2">+680 CFA/mois par enfant dès le 5ᵉ</td></tr>
                    </table>
                </div>
                <div class="card-detail">
                    <button class="card-detail-trigger" onclick="toggleDetail(this)">
                        <i class="fas fa-chevron-down"></i> Voir les détails
                    </button>
                    <div class="card-detail-content">
                        <ul>
                            <li><i class="fas fa-check-circle"></i> <strong>Couverture totale :</strong> 9 000 000 CFA</li>
                            <li><i class="fas fa-check-circle"></i> <strong>Bénéficiaires :</strong> Adhérent + Conjoint + Enfants (4 max) + 1 Ascendant</li>
                            <li><i class="fas fa-check-circle"></i> <strong>4ᵉ enfant :</strong> +680 CFA/mois par enfant supplémentaire</li>
                            <li><i class="fas fa-check-circle"></i> <strong>Délai de carence :</strong>  3 mois</li>
                            <li><i class="fas fa-check-circle"></i> <strong>Validité :</strong> 12 mois renouvelable</li>
                            <li><i class="fas fa-check-circle"></i> <strong>Assistance premium :</strong> Rapatriement inclus</li>
                        </ul>
                    </div>
                </div>
                <div class="card-total">
                    <div>
                        <span class="total-label">Total garanti</span>
                        <div class="total-amount">9 000 000 CFA <span>(1 ascendant)</span></div>
                    </div>
                    <button class="btn-select" onclick="selectOption(this)">Choisir</button>
                </div>
            </div>

            <!-- OPTION 3 - ÉCONOMIQUE -->
            {{-- <div class="card card-economique" data-formule="economique" data-prime="4400" data-capital="5000000">
                <div class="card-header">
                    <div class="option-badge">FORMULE ÉCONOMIQUE</div>
                    <h3>OPTION 3</h3>
                    <div class="price">
                        <div class="price-item">
                            <div class="amount">4 400 CFA</div>
                            <span class="label">/ Mois</span>
                        </div>
                        <div class="price-item">
                            <div class="amount">52 800 CFA</div>
                            <span class="label">/ An</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="guarantees-table">
                        <tr><td class="category">👤 Adhérent</td><td class="value highlight">2 000 000 CFA</td></tr>
                        <tr><td class="category">👩 Conjoint(e)</td><td class="value highlight">2 000 000 CFA</td></tr>
                        <tr><td class="category">👶 Enfants (jusqu'à 5)</td><td class="value">1 000 000 CFA</td></tr>
                        <tr><td class="category">👴 Ascendant(s)</td><td class="value" style="color:#999;">Non inclus</td></tr>
                        <tr class="note-row"><td colspan="2">+500 CFA/mois par enfant dès le 6ᵉ</td></tr>
                    </table>
                </div>
                <div class="card-detail">
                    <button class="card-detail-trigger" onclick="toggleDetail(this)">
                        <i class="fas fa-chevron-down"></i> Voir les détails
                    </button>
                    <div class="card-detail-content">
                        <ul>
                            <li><i class="fas fa-check-circle"></i> <strong>Couverture totale :</strong> 5 000 000 CFA</li>
                            <li><i class="fas fa-check-circle"></i> <strong>Bénéficiaires :</strong> Adhérent + Conjoint + Enfants (5 max)</li>
                            <li><i class="fas fa-check-circle"></i> <strong>6ᵉ enfant :</strong> +500 CFA/mois par enfant supplémentaire</li>
                            <li><i class="fas fa-check-circle"></i> <strong>Délai de carence :</strong> 6 mois</li>
                            <li><i class="fas fa-check-circle"></i> <strong>Validité :</strong> 12 mois renouvelable</li>
                            <li><i class="fas fa-check-circle"></i> <strong>Assistance :</strong> Standard (8h-18h)</li>
                        </ul>
                    </div>
                </div>
                <div class="card-total">
                    <div>
                        <span class="total-label">Total garanti</span>
                        <div class="total-amount">5 000 000 CFA <span>(hors ascendants)</span></div>
                    </div>
                    <button class="btn-select outline" onclick="selectOption(this)">Choisir</button>
                </div>
            </div> --}}
        </div>

        <!-- BANDEAU INFO -->
        <div class="info-banner">
            <i class="fas fa-circle-info"></i>
            <div>Toutes les formules couvrent jusqu'à <strong>4 enfants</strong>. À partir du <strong>5ᵉ enfant</strong>, une prime supplémentaire de <strong>680 CFA/mois</strong> par enfant est appliquée.</div>
        </div>

        <!-- COMPARATIF -->
        <div class="comparatif">
            <h3><i class="fas fa-chart-bar"></i> Comparatif des formules</h3>
            <table>
                <thead>
                    <tr>
                        <th>Critères</th>
                        <th style="color:#1a2a6c;">Option 1 (Complète)</th>
                        <th style="color:#6a1b9a;">Option 2 (Premium)</th>
                        {{-- <th style="color:#1a5a3c;">Option 3 (Économique)</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Prime mensuelle</td>
                        <td style="font-weight:700;color:#1a2a6c;">9 672 CFA</td>
                        <td style="color:#6a1b9a;">7 652 CFA</td>
                        {{-- <td style="color:#1a5a3c;">4 400 CFA</td> --}}
                    </tr>
                    <tr>
                        <td>Ascendants couverts</td>
                        <td>✅ 2 x 1 000 000 CFA</td>
                        <td>✅ 1 x 1 000 000 CFA</td>
                        {{-- <td>❌ Non inclus</td> --}}
                    </tr>
                    <tr>
                        <td>Enfants pris en charge</td>
                        <td colspan="3">4 enfants inclus, +680 CFA/mois dès le 5ᵉ</td>
                    </tr>
                    <tr>
                        <td>Délai de carence</td>
                        <td>3 mois</td>
                        <td>3 mois</td>
                        {{-- <td>6 mois</td> --}}
                    </tr>
                    <tr>
                        <td>Assistance</td>
                        <td>24h/24</td>
                        <td>24h/24</td>
                        {{-- <td>Standard</td> --}}
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
                const user = @json($user);

                let data = JSON.parse(sessionStorage.getItem('souscriptionData') || '{}');

                // Met à jour uniquement si l'utilisateur n'est pas encore sauvegardé
                if (!data.utilisateur) {
                    data.utilisateur = user;
                    sessionStorage.setItem('souscriptionData', JSON.stringify(data));
                    console.log('✅ Utilisateur sauvegardé dans la session :', data.utilisateur);
                } else {
                    console.log('ℹ️ Utilisateur déjà présent dans la session :', data.utilisateur);
                }
            });
    </script>

    <script>
        /**
         * Bascule l'accordéon des détails
         */
        function toggleDetail(button) {
            const content = button.nextElementSibling;
            content.classList.toggle('open');
            button.classList.toggle('active');

            if (content.classList.contains('open')) {
                button.innerHTML = '<i class="fas fa-chevron-up"></i> Masquer les détails';
            } else {
                button.innerHTML = '<i class="fas fa-chevron-down"></i> Voir les détails';
            }
        }

        /**
         * Sélectionne une formule et enregistre les données en sessionStorage
         */
        function selectOption(button) {
            // Récupère la carte parente
            const card = button.closest('.card');
            if (!card) return;

            const user = @json($user);

            // Lecture des attributs data-
            const formule = card.dataset.formule || 'unknown';
            const prime = parseInt(card.dataset.prime, 10) || 0;
            const capital = parseInt(card.dataset.capital, 10) || 0;

            // Construction de l'objet de souscription
            const souscriptionData = {
                simulationData: {
                    formule: formule,
                    productCode: 'LFFUN',
                    prime: prime,
                    capital: capital,
                    dateSelection: new Date().toISOString()
                },
                utilisateur:user

            };

            // Enregistrement en sessionStorage
            try {
                sessionStorage.setItem('souscriptionData', JSON.stringify(souscriptionData));
                console.log('✅ Données enregistrées :', souscriptionData);

                // Feedback visuel
                const originalText = button.textContent;
                button.textContent = '✓ Sélectionné';
                button.style.opacity = '0.8';
                setTimeout(() => {
                    button.textContent = originalText;
                    button.style.opacity = '1';
                }, 2400);

                // Option : redirection vers la page suivante
                window.location.href = '/site/create/LFFUN/INPHB?formule=' + encodeURIComponent(formule);

            } catch (e) {
                console.error('❌ Erreur lors de l\'enregistrement :', e);
                alert('Une erreur est survenue lors de l\'enregistrement de votre choix.');
            }
        }

        /**
         * Au chargement : ouvre automatiquement les détails de la carte recommandée
         */
        document.addEventListener('DOMContentLoaded', function() {
            const recommendedCard = document.querySelector('.card.recommended');
            if (recommendedCard) {
                const trigger = recommendedCard.querySelector('.card-detail-trigger');
                if (trigger) {
                    setTimeout(() => {
                        toggleDetail(trigger);
                    }, 400);
                }
            }

            // Vérification du contenu de la session (debug)
            const stored = sessionStorage.getItem('souscriptionData');
            if (stored) {
                try {
                    console.log('📦 Données existantes en session :', JSON.parse(stored));
                } catch (e) {
                    // ignoré
                }
            }
        });
    </script>
</body>
</html>
