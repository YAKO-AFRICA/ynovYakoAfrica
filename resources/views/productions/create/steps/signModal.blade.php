<div class="modal fade" id="qrCodeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center">Signature electroique</h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>

            <div class="modal-body">
                

                <div class="card p-2">
                    <div class="card-header text-center">
                        <h4>Veuillez scanner ce code QR pour éffectuer votre signature</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-center justify-content-center">
                                {!! QrCode::size(200)->generate(url('https://apisign.yakoafricassur.com/signature/'.$token['token'].'/'.$token['operation_type'].'/'.$token['key_uuid'])) !!}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12">
                                Vous pouvez également signer en cliquant: 
                                <a href="https://apisign.yakoafricassur.com/signature/{{ $token['token'] }}/{{ $token['operation_type'] }}/{{ $token['key_uuid'] }}" target="_blank">
                                    <strong>ICI</strong>
                                </a>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div> --}}
            </div>
        </div>
    </div>