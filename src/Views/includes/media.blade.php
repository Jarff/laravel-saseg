<div class="modal fade" id="modal-media" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true" data-route="{{ route('images.show') }}">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-default">Tus archivos</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" style="overflow-y: scroll;max-height: 600px;">
                <div class="row modal-media">
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="d-none btn btn-primary media-save-changes">Guardar cambios</button>
                <button type="button" class="btn btn-default  ml-auto" data-dismiss="modal">Cerrar</button>
            </div>
            
        </div>
    </div>
</div>