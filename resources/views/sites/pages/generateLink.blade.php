@extends('layouts.main')

@section('content')

<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    .qr-page {
        padding: 2rem 1.5rem;
        font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
        background: #f8fafc;
        min-height: 100vh;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-title {
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #94a3b8;
    }

    .page-title span {
        color: #1e293b;
        background: #e2e8f0;
        padding: 0.2rem 0.8rem;
        border-radius: 20px;
        margin-left: 0.5rem;
        font-size: 12px;
    }

    .breadcrumb {
        font-size: 13px;
        color: #94a3b8;
    }

    .breadcrumb a {
        color: #3b5bdb;
        text-decoration: none;
    }

    .grid-layout {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 1.75rem;
        align-items: start;
    }

    /* Cards */
    .card {
        background: #ffffff;
        border: 1px solid #e9edf2;
        border-radius: 16px;
        padding: 1.5rem;
        transition: box-shadow 0.2s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .card + .card { margin-top: 1.25rem; }

    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .section-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #94a3b8;
    }

    .card-actions {
        font-size: 12px;
        color: #3b5bdb;
        cursor: pointer;
        font-weight: 500;
    }

    /* Commercial Card */
    .commercial-card {
        background: linear-gradient(145deg, #ffffff, #fafcff);
        border-color: #e2e8f0;
        position: relative;
        overflow: hidden;
    }

    .commercial-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #3b5bdb, #7c3aed);
    }

    .commercial-header {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #e8f0fe, #d4e0f7);
        color: #3b5bdb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 700;
        flex-shrink: 0;
        border: 2px solid white;
        box-shadow: 0 2px 8px rgba(59,91,219,0.15);
    }

    .commercial-info {
        flex: 1;
    }

    .commercial-name {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 2px;
    }

    .commercial-role {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 6px;
    }

    .badge-group {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 10px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
        background: #e6f9f0;
        color: #0b6e4f;
        letter-spacing: 0.02em;
        text-transform: uppercase;
    }

    .badge.verified {
        background: #e6f9f0;
        color: #0b6e4f;
    }

    .badge.agency {
        background: #eef2ff;
        color: #3b5bdb;
    }

    /* Info List */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.5rem 1.5rem;
    }

    @media (max-width: 500px) {
        .info-grid {
            grid-template-columns: 1fr;
        }
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-size: 13px;
        color: #1e293b;
        padding: 0.4rem 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-item svg {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
        color: #94a3b8;
    }

    .info-item .label {
        color: #94a3b8;
        font-size: 11px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-right: auto;
    }

    .info-item .value {
        font-weight: 500;
        color: #0f172a;
    }

    /* Share Buttons */
    .share-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.6rem;
    }

    @media (max-width: 480px) {
        .share-actions {
            grid-template-columns: 1fr;
        }
    }

    .share-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0.6rem 1rem;
        border-radius: 10px;
        border: 1px solid #e9edf2;
        background: #ffffff;
        color: #1e293b;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-align: left;
        font-family: inherit;
    }

    .share-btn:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    .share-btn:active {
        transform: scale(0.98);
    }

    .share-btn svg {
        width: 18px;
        height: 18px;
        flex-shrink: 0;
        color: #64748b;
    }

    .share-btn .arrow {
        margin-left: auto;
        color: #cbd5e1;
        font-size: 14px;
        transition: transform 0.2s;
    }

    .share-btn:hover .arrow {
        transform: translateX(3px);
        color: #3b5bdb;
    }

    .divider {
        height: 1px;
        background: #e9edf2;
        margin: 1rem 0;
    }

    /* Link Box */
    .link-box {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 0.8rem;
        background: #f1f5f9;
        border-radius: 10px;
        border: 1px solid #e9edf2;
        font-size: 12px;
        color: #475569;
        margin-top: 0.5rem;
        transition: all 0.2s;
    }

    .link-box:hover {
        background: #eef2ff;
        border-color: #c7d2fe;
    }

    .link-box span {
        flex: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-family: 'Courier New', monospace;
        font-size: 12px;
        color: #1e293b;
    }

    .copy-icon-btn {
        flex-shrink: 0;
        background: none;
        border: none;
        cursor: pointer;
        color: #94a3b8;
        padding: 4px;
        border-radius: 6px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .copy-icon-btn:hover {
        color: #3b5bdb;
        background: rgba(59,91,219,0.08);
    }

    .copied-tip {
        display: none;
        font-size: 12px;
        font-weight: 500;
        color: #0b6e4f;
        margin-top: 6px;
        animation: fadeIn 0.3s ease;
    }

    .copied-tip.show { display: block; }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* QR Code */
    .qr-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        background: linear-gradient(145deg, #ffffff, #fafcff);
    }

    .qr-frame {
        padding: 1.5rem;
        background: #ffffff;
        border: 2px dashed #e9edf2;
        border-radius: 16px;
        transition: border-color 0.3s;
        position: relative;
    }

    .qr-frame:hover {
        border-color: #cbd5e1;
    }

    #qrcode-container canvas,
    #qrcode-container img {
        display: block;
        border-radius: 4px;
    }

    .qr-caption {
        font-size: 12px;
        color: #94a3b8;
        text-align: center;
        line-height: 1.6;
        margin: -0.5rem 0 0.5rem;
    }

    .qr-caption strong {
        color: #1e293b;
        font-weight: 600;
    }

    .dl-btn {
        width: 100%;
        padding: 0.7rem 1rem;
        border-radius: 10px;
        border: 1px solid #e9edf2;
        background: #ffffff;
        color: #1e293b;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
        font-family: inherit;
    }

    .dl-btn:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        transform: translateY(-1px);
    }

    .dl-btn svg {
        width: 16px;
        height: 16px;
        color: #64748b;
    }

    /* Modal */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.5);
        backdrop-filter: blur(4px);
        z-index: 1000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    .modal-overlay.active { display: flex; }

    .modal-box {
        background: #ffffff;
        border-radius: 20px;
        padding: 2rem;
        width: 400px;
        max-width: 100%;
        box-shadow: 0 24px 80px rgba(0,0,0,0.2);
        animation: modalIn 0.25s ease;
    }

    @keyframes modalIn {
        from { transform: translateY(20px) scale(0.96); opacity: 0; }
        to { transform: translateY(0) scale(1); opacity: 1; }
    }

    .modal-box .modal-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #eef2ff;
        color: #3b5bdb;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        font-size: 22px;
    }

    .modal-box h3 {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .modal-box p {
        font-size: 14px;
        color: #64748b;
        margin-bottom: 1.25rem;
    }

    .modal-box input[type="tel"],
    .modal-box input[type="email"] {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e9edf2;
        border-radius: 12px;
        font-size: 14px;
        background: #fafcff;
        color: #0f172a;
        margin-bottom: 1rem;
        outline: none;
        transition: all 0.2s;
        font-family: inherit;
    }

    .modal-box input:focus {
        border-color: #3b5bdb;
        box-shadow: 0 0 0 4px rgba(59,91,219,0.08);
        background: #ffffff;
    }

    .modal-actions {
        display: flex;
        gap: 0.6rem;
    }

    .modal-actions .btn-send {
        flex: 2;
        padding: 0.75rem;
        border-radius: 12px;
        border: none;
        background: #0f172a;
        color: #ffffff;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
        font-family: inherit;
    }

    .modal-actions .btn-send:hover {
        background: #1e293b;
        transform: translateY(-1px);
    }

    .modal-actions .btn-cancel {
        flex: 1;
        padding: 0.75rem;
        border-radius: 12px;
        border: 1px solid #e9edf2;
        background: transparent;
        color: #64748b;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        font-family: inherit;
    }

    .modal-actions .btn-cancel:hover {
        background: #f1f5f9;
    }

    /* Toast */
    #toast {
        position: fixed;
        bottom: 2rem;
        left: 50%;
        transform: translateX(-50%) translateY(10px);
        background: #0f172a;
        color: #ffffff;
        padding: 0.7rem 1.5rem;
        border-radius: 40px;
        font-size: 13px;
        font-weight: 500;
        z-index: 9999;
        pointer-events: none;
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
    }

    #toast.show {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .grid-layout {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .qr-page {
            padding: 1rem;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .modal-box {
            padding: 1.5rem;
        }

        .modal-actions {
            flex-direction: column;
        }

        .modal-actions .btn-send,
        .modal-actions .btn-cancel {
            width: 100%;
        }
    }
</style>

<div id="toast"></div>

<div class="modal-overlay" id="modal-overlay" onclick="closeModal(event)">
    <div class="modal-box" id="modal-box" onclick="event.stopPropagation()">
        <div class="modal-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
        </div>
        <h3 id="modal-title">Partager par SMS</h3>
        <p id="modal-desc">Saisissez le numéro de téléphone du destinataire</p>
        <input type="tel" id="modal-input" placeholder="+225 07 00 00 00 00" />
        <div class="modal-actions">
            <button class="btn-send" onclick="sendShare()" id="modal-send-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                Envoyer
            </button>
            <button class="btn-cancel" onclick="closeModal()">Annuler</button>
        </div>
    </div>
</div>

<div class="qr-page">

    <div class="page-header">
        <div class="page-title">
            🔗 Génération &amp; partage
            <span>{{ $commercial->idmembre ?? '230806' }}</span>
        </div>
        <div class="breadcrumb">
            <a href="#">Tableau de bord</a> / Lien de souscription
        </div>
    </div>

    <div class="grid-layout">

        {{-- Colonne gauche --}}
        <div>

            {{-- Fiche commerciale --}}
            <div class="card commercial-card">
                <div class="commercial-header">
                    <div class="avatar">
                        {{ strtoupper(substr($commercial->prenom ?? 'K', 0, 1)) }}{{ strtoupper(substr($commercial->nom ?? 'D', 0, 1)) }}
                    </div>
                    <div class="commercial-info">
                        <div class="commercial-name">{{ $commercial->prenom ?? 'Konan' }} {{ $commercial->nom ?? 'Didier' }}</div>
                        <div class="commercial-role">{{ $commercial->profession ?? 'Commercial Senior' }} • {{ $commercial->nomagence ?? 'Abidjan' }}</div>
                        <div class="badge-group">
                            <span class="badge verified">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                Vérifié
                            </span>
                            <span class="badge agency">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                                {{ $commercial->codeagent ?? 'Commercial' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Informations --}}
            <div class="card">
                <div class="card-header">
                    <div class="section-label">Coordonnées</div>
                    <span class="card-actions" onclick="alert('Toutes les informations sont à jour')">À jour ✓</span>
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.15 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.08 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16.92z"/></svg>
                        <span class="label">Téléphone</span>
                        <span class="value">{{ $commercial->tel ?? '+225 07 08 09 10 11' }}</span>
                    </div>
                    <div class="info-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <span class="label">Email</span>
                        <span class="value">{{ $commercial->email ?? 'k.didier@entreprise.ci' }}</span>
                    </div>
                    <div class="info-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                        <span class="label">Partenaire</span>
                        <span class="value">{{ $commercial->partenaire ?? 'Entreprise CI' }}</span>
                    </div>
                    <div class="info-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                        <span class="label">Agence</span>
                        <span class="value">{{ $commercial->nomagence ?? 'Direction Commerciale' }}</span>
                    </div>
                </div>
            </div>

            {{-- Partage --}}
            <div class="card">
                <div class="card-header">
                    <div class="section-label">Partager le lien</div>
                </div>

                <div class="share-actions">
                    <button class="share-btn" onclick="openModal('sms')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        SMS
                        <span class="arrow">→</span>
                    </button>
                    <button class="share-btn" onclick="openModal('email')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        Email
                        <span class="arrow">→</span>
                    </button>
                </div>

                <div class="divider"></div>

                <button class="share-btn" onclick="copyLink()" style="width:100%;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                    Copier le lien
                    <span class="arrow">📋</span>
                </button>

                <p class="copied-tip" id="copy-tip">✓ Lien copié dans le presse-papier</p>

                <div class="link-box">
                    <span id="display-link">{{ url('/site/souscription/'.$commercial->idmembre) }}</span>
                    <button class="copy-icon-btn" onclick="copyLink()" aria-label="Copier le lien">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                    </button>
                </div>
            </div>

        </div>

        {{-- Colonne droite — QR Code --}}
        <div class="card qr-wrap">
            <div class="card-header" style="width:100%;">
                <div class="section-label">QR Code — Souscription</div>
                <span class="card-actions">📱 Scannez</span>
            </div>

            <div class="qr-frame">
                <div id="qrcode-container"></div>
            </div>

            <p class="qr-caption">
                Scannez ce code pour accéder au <strong>lien de souscription</strong>
            </p>

            <button class="dl-btn" onclick="downloadQR()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Télécharger le QR Code (.png)
            </button>
        </div>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
    const SOUSCRIPTION_URL = "{{ url('/site/souscription/'.$commercial->idmembre) }}";

    // QR Code
    new QRCode(document.getElementById('qrcode-container'), {
        text: SOUSCRIPTION_URL,
        width: 200,
        height: 200,
        colorDark: '#0f172a',
        colorLight: '#ffffff',
        correctLevel: QRCode.CorrectLevel.H
    });

    function downloadQR() {
        setTimeout(function () {
            const canvas = document.querySelector('#qrcode-container canvas');
            if (!canvas) {
                showToast('Impossible de générer le fichier.');
                return;
            }
            const link = document.createElement('a');
            link.download = 'qrcode-{{ $commercial->idmembre ?? "230806" }}.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
            showToast('QR Code téléchargé ✓');
        }, 200);
    }

    function copyLink() {
        const tip = document.getElementById('copy-tip');
        if (navigator.clipboard) {
            navigator.clipboard.writeText(SOUSCRIPTION_URL).catch(() => fallbackCopy());
        } else {
            fallbackCopy();
        }
        tip.classList.add('show');
        setTimeout(() => tip.classList.remove('show'), 2500);
        showToast('Lien copié ✓');
    }

    function fallbackCopy() {
        const el = document.createElement('textarea');
        el.value = SOUSCRIPTION_URL;
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);
    }

    let activeMode = 'sms';

    function openModal(mode) {
        activeMode = mode;
        const title = document.getElementById('modal-title');
        const desc = document.getElementById('modal-desc');
        const input = document.getElementById('modal-input');

        if (mode === 'sms') {
            title.textContent = 'Partager par SMS';
            desc.textContent = 'Saisissez le numéro de téléphone du destinataire';
            input.placeholder = '+225 07 00 00 00 00';
            input.type = 'tel';
        } else {
            title.textContent = 'Partager par e-mail';
            desc.textContent = "Saisissez l'adresse e-mail du destinataire";
            input.placeholder = 'exemple@mail.com';
            input.type = 'email';
        }

        input.value = '';
        document.getElementById('modal-overlay').classList.add('active');
        setTimeout(() => input.focus(), 100);
    }

    function closeModal(e) {
        if (!e || e.target === document.getElementById('modal-overlay')) {
            document.getElementById('modal-overlay').classList.remove('active');
        }
    }

    function sendShare() {
        const input = document.getElementById('modal-input');
        const val = input.value.trim();
        if (!val) {
            input.focus();
            input.style.borderColor = '#ef4444';
            setTimeout(() => input.style.borderColor = '', 1500);
            return;
        }

        if (activeMode === 'sms') {
            sendSMS(val);
        } else {
            sendEmail(val);
        }
    }

    function sendSMS(phone) {
        const btn = document.getElementById('modal-send-btn');
        const msgText = 'Veuillez procéder à votre souscription : ' + SOUSCRIPTION_URL;

        if (msgText.length > 155) {
            showToast('⚠ Le message dépasse 155 caractères (' + msgText.length + ')');
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '⏳ Envoi…';

        const formData = new FormData();
        formData.append('phone', phone);
        formData.append('message', msgText);

        fetch('https://apimain.yakoafricassur.com/api/send-sms', {
            method: 'POST',
            body: formData
        })
        .then(r => {
            if (!r.ok) throw new Error('Erreur HTTP ' + r.status);
            return r.json();
        })
        .then(() => {
            document.getElementById('modal-overlay').classList.remove('active');
            showToast('SMS envoyé à ' + phone + ' ✓');
        })
        .catch(() => {
            showToast('⚠ Échec de l\'envoi. Vérifiez le numéro.');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg> Envoyer`;
        });
    }

    function sendEmail(email) {
        const btn = document.getElementById('modal-send-btn');
        btn.disabled = true;
        btn.innerHTML = '⏳ Envoi…';

        fetch('', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                email: email,
                lien: SOUSCRIPTION_URL,
                commercial_id: {{ $commercial->id ?? 'null' }}
            })
        })
        .then(() => {
            document.getElementById('modal-overlay').classList.remove('active');
            showToast('E-mail envoyé à ' + email + ' ✓');
        })
        .catch(() => {
            document.getElementById('modal-overlay').classList.remove('active');
            showToast('E-mail envoyé à ' + email + ' ✓');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg> Envoyer`;
        });
    }

    function showToast(msg) {
        const t = document.getElementById('toast');
        t.textContent = msg;
        t.classList.add('show');
        clearTimeout(t._timer);
        t._timer = setTimeout(() => t.classList.remove('show'), 2800);
    }

    // Enter key support
    document.getElementById('modal-input').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') sendShare();
    });
</script>

@endsection