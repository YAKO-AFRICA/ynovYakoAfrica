<div class="modal fade" id="otpModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="otpModalLabel">
{{-- aria-labelledby="otpModalLabel" --}}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> --}}
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div id="OTPSendID">
                <form action="" method="post" id="sendOTPForm">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="operation_type" id="operation_type" value="Demande de prestation">
    
                        <div class="row" id="phoneInputGroup">
                            <div class="input-group mb-3">
                                <div class="input-group-text">
                                    <select class="form-select form-select-sm country-select" id="countryPrefix"
                                        aria-label="Indicatif Pays" required>
                                        <option selected value="">🌍 Pays</option>
                                        @foreach ($detailCountries as $item)
                                            <option value="{{ $item['phone_international_prefix'] }}" {{ $item['phone_international_prefix'] == '225' ? 'selected' : '' }}>
                                                +{{ $item['phone_international_prefix'] }}
                                                {{ $item['flag'] }}
                                            </option>
                                        @endforeach
    
                                    </select>
                                </div>
                                <input type="text" class="form-control" name="telephone" id="phoneInput"
                                    aria-label="Numéro de téléphone" placeholder="Numéro de téléphone" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary p-2" data-bs-dismiss="modal">Fermer</button>
                        <button type="button" class="btn btn-primary p-2" id="sendOTPButton">Envoyer le code</button>
                    </div>
                </form>
            </div>
            
            <div id="OTPVerifyID" class="d-none">
                <!-- FORMULAIRE DE VÉRIFICATION D’OTP -->
                <form action="" method="post" id="verifyOTPForm">
                    <div class="modal-body">
                        @csrf
                        <!-- Champs cachés -->
                        <input type="hidden" name="telephone" id="hiddenTelephone">
                        <input type="hidden" name="telIndicatif" id="hiddenIndicatif">
    
                        <div class="row g-3 mb-3 text-center" id="OTPContainer">
                            <span class="form-label">Un code de confirmation a été envoyé par SMS, veuillez le
                                rentrer ci-dessous</span>
                            <div class="col-12 d-flex justify-content-center align-items-center">
                                <div class="otp-container">
                                    <input type="text" class="otp-input" id="modalOtp_1" maxlength="1">
                                    <input type="text" class="otp-input" id="modalOtp_2" maxlength="1">
                                    <input type="text" class="otp-input" id="modalOtp_3" maxlength="1">
                                    <input type="text" class="otp-input" id="modalOtp_4" maxlength="1">
                                    <input type="text" class="otp-input" id="modalOtp_5" maxlength="1">
                                    <input type="text" class="otp-input" id="modalOtp_6" maxlength="1">
                                </div>
                            </div>
                            <div class="otp-expi-time" id="otp-expi-time">
                                {{-- afficher le deconte ici  --}}
                            </div>
                            <a href="#" class="d-none resend-otp-btn">Renvoyer l'OTP</a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary p-2" id="changePhoneButtonForMobileMoney" disabled>Modifier le numéro</button>
                        <button type="button" class="btn btn-secondary p-2" id="changePhoneButton" disabled>Modifier le numéro</button>
                        
                        <button type="button" id="verifyOtpButton" class="btn btn-primary p-2">
                            Vérifier <i class='bx bx-right-arrow-alt'></i>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
