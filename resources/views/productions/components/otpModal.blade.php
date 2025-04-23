<div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="OTPSendID">
                <form action="" method="post" id="sendOTPForm">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="operation_type" id="operation_type" value="Souscription">
    
                        <div class="row" id="phoneInputGroup">
                            <div class="input-group mb-3">
                                <div class="input-group-text">
                                    <select class="form-select form-select-sm country-select" id="countryPrefix"
                                        aria-label="Indicatif Pays" required>
                                        <option selected disabled value="">🌍 Pays</option>
                                        @foreach ($detailCountries as $item)
                                            <option value="{{ $item['phone_international_prefix'] }}">
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="button" class="btn btn-primary" id="sendOTPButton">Envoyer le code</button>
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
    
                        <div class="row g-3 mb-3 text-center" id="OTP">
                            <span class="form-label">Un code de confirmation a été envoyé par SMS, veuillez le
                                rentrer ci-dessous</span>
                            <div class="col-12 d-flex justify-content-center align-items-center">
                                <div class="otp-container">
                                    <input type="text" class="otp-input" maxlength="1">
                                    <input type="text" class="otp-input" maxlength="1">
                                    <input type="text" class="otp-input" maxlength="1">
                                    <input type="text" class="otp-input" maxlength="1">
                                    <input type="text" class="otp-input" maxlength="1">
                                    <input type="text" class="otp-input" maxlength="1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        {{-- <button onclick="event.preventDefault(); stepper1.next()" class="btn btn-two btn-next-form">Vérifier<i
                            class='bx bx-right-arrow-alt'></i></button> --}}
                            <button type="button" id="verifyOtpButton" class="btn btn-two btn-next-form">
                                Vérifier <i class='bx bx-right-arrow-alt'></i>
                            </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
