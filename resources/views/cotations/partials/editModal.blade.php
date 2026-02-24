<div class="modal fade" id="traiterModal" tabindex="-1" aria-labelledby="traiterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Traiter la cotation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('cotation.update', $cotation->uuid) }}" method="POST" class="submitForm">
                @csrf

                <div class="modal-body">
                    <input type="hidden" name="uuid" value="{{ $cotation->uuid }}">

                    {{-- Prime --}}
                    <div class="mb-3">
                        <label class="form-label">Prime definitive</label>
                        <div class="input-group">
                            <input
                                type="number"
                                name="prime"
                                id="prime"
                                class="form-control"
                                required
                                min="0"
                                step="0.01"
                                inputmode="decimal"
                                oninput="this.value = this.value.replace(/[^0-9.]/g,'')"
                            >
                            <span class="input-group-text">FCFA</span>
                        </div>
                    </div>

                    {{-- Surprime --}}
                    <div class="mb-3">
                        <label class="form-label">Surprime</label>
                        <div class="input-group">
                            <input
                                type="number"
                                name="surprime"
                                id="surprime"
                                class="form-control"
                                min="0"
                                step="0.01"
                                inputmode="decimal"
                                oninput="this.value = this.value.replace(/[^0-9.]/g,'')"
                            >
                            <span class="input-group-text">FCFA</span>
                        </div>
                    </div>

                    {{-- Note --}}
                    <div class="mb-3">
                        <label class="form-label">Note</label>
                        <textarea name="note" rows="3" class="form-control"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Traiter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('input[type=number]').forEach(function (el) {

        // bloque e, +, -
        el.addEventListener('keydown', function (e) {
            if (['e', 'E', '+', '-'].includes(e.key)) {
                e.preventDefault();
            }
        });

        // bloque scroll souris
        el.addEventListener('wheel', function (e) {
            e.target.blur();
        });
    });
});
</script>
