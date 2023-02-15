<div class="modal fade modal-top" id="alterar-evento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-ticket-alt text-dark"></i> Alterar Evento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="evento">Selecione o evento
                    <span class="text-danger">*</span></label>
                    <select class="form-control mb-3" id="evento">
                        <option value="">Selecione um evento</option>
                    </select>
                    <span class="error-evento text-danger mt-3"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger font-weight-bold" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
                <button type="button" id="btn-alterar-evento" class="btn btn-primary font-weight-bold"><i class="fa fa-check"></i> Alterar Evento</button>
            </div>
        </div>
    </div>
</div>