import axios from 'axios';
import Dropzone, { createElement } from 'dropzone';
import LoaderRod from '../loader-rod';
require('dropzone/dist/min/dropzone.min.css');

export default (function(){
    let instances = {};
    Dropzone.autoDiscover = false;
    // Dropzone.prototype.defaultOptions.dictDefaultMessage = "Suelta tu(s) archivo(s) aquí";
    // Dropzone.prototype.defaultOptions.dictFallbackMessage = "Su navegador no soporta arrastar y soltar archivos.";
    // Dropzone.prototype.defaultOptions.dictFallbackText = "Please use the fallback form below to upload your files like in the olden days.";
    // Dropzone.prototype.defaultOptions.dictFileTooBig = "El archivo es demasiado grande ({{filesize}}MiB). Max tamaño de archivo: {{maxFilesize}}MiB.";
    // Dropzone.prototype.defaultOptions.dictInvalidFileType = "No puede subir archivo de ese tipo.";
    // Dropzone.prototype.defaultOptions.dictResponseError = "El servidor respondió con un status {{statusCode}} de código.";
    // Dropzone.prototype.defaultOptions.dictCancelUpload = "Cancelar subida";
    // Dropzone.prototype.defaultOptions.dictCancelUploadConfirmation = "Está seguro de cancelar está subida?";
    // Dropzone.prototype.defaultOptions.dictRemoveFile = "Remover archivo";
    // Dropzone.prototype.defaultOptions.dictMaxFilesExceeded = "No puedes subir más archivos.";
    if(document.querySelector('.dropzone')){
        let dropzones = document.querySelectorAll('.dropzone');
        Array.from(dropzones).forEach((dr) => {
            if(dr.classList.contains('multiple')){
                //Creamos una instancia unica para dropzone instanciado en la vista
                let uuid = dr.getAttribute('id');
                console.log(uuid);
                var myDropzone = new Dropzone('#'+uuid, {
                    url: dr.dataset.route,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    hiddenInputContainer: "div#"+uuid,
                    parallelUploads:10,
                    uploadMultiple:true,
                    addRemoveLinks: true,
                    acceptedFiles: 'image/*',
                    dictDefaultMessage: 'Arrastra tus imágenes aquí (o click) para subir',
                    dictRemoveFile: "Remover archivo",
                    init: function() {
                        var curr = this;
                        instances[uuid] = this;
                        // if(document.querySelector('.select-uploaded')){
                            
                        // }
                        if(document.getElementById('modal-media')){
                            $("#modal-media").on('show.bs.modal', function(e){
                                if(e.relatedTarget.dataset.reference){
                                    if(document.querySelector('.media-save-changes')){
                                        document.querySelector('.media-save-changes').classList.remove('d-none');
                                    }
                                    let uuid = e.relatedTarget.dataset.reference;
                                    LoaderRod.show();
                                    axios.get(document.getElementById('modal-media').dataset.route)
                                    .then(response => {
                                        if(response.data.success){
                                            document.querySelector('.row.modal-media').innerHTML = response.data.files.map((file, i) => {
                                                return `
                                                <div class="col-sm-3 position-relative">
                                                    <div class="custom-control custom-checkbox position-absolute" style="top: 10px;z-index: 99;right: 15px;">
                                                        <input type="checkbox" class="custom-control-input select-uploaded" id="media-checkbox-${i}" data-path="${file.path}" data-name="${file.name}" data-type="${file.type}" data-size="${file.size}" data-target="${i}-media">
                                                        <label class="custom-control-label" for="media-checkbox-${i}"></label>
                                                    </div>
                                                    <div class="card">
                                                        <img id="${i}-media" class="card-img" src="${file.url}" alt="Card image">
                                                    </div>
                                                </div>`;
                                            }).join("");
                                        }
                                        LoaderRod.destroy();
                                        //Listener para guardar seleccionados
                                        if(document.querySelector('.media-save-changes')){
                                            document.querySelector('.media-save-changes').addEventListener('click', e => {
                                                let uploads = document.querySelectorAll('input.select-uploaded:checked');
                                                let mocks = [];
                                                //Removemos el actual preview
                                                $('#'+uuid+' div.dz-preview').remove();
                                                dr = document.getElementById(uuid);
                                                Array.from(uploads).forEach(up => {
                                                    let mock = {file_name: up.dataset.path, name: up.dataset.name, size: up.dataset.size, type: up.dataset.type};
                                                    mocks.push(mock);
                                                    instances[uuid].displayExistingFile(mock, document.getElementById(up.dataset.target).getAttribute('src'));
                                                });
                                                $('#modal-media').modal('hide');
                                                document.querySelector(dr.dataset.target).value = JSON.stringify(mocks);
                                            });
                                        }
                                    })
                                    .catch(err => {
                                        console.log(err);
                                        LoaderRod.destroy();
                                    });
                                }else{
                                    console.error('data-reference on anchor is missing');
                                }
                            });
                        }
                        if(document.querySelector(dr.dataset.target).dataset.current){
                            let images = JSON.parse(document.querySelector(dr.dataset.target).dataset.current);
                            images.map(cur => {
                                let mock = {name: cur.image, type: 'image/*'};
                                this.displayExistingFile(mock, document.querySelector(dr.dataset.target).dataset.asset+cur.image);
                                this.options.thumbnail.call(this, mock, document.querySelector(dr.dataset.target).dataset.asset+cur.image);
                            });
                        }
                        this.on("success", (file, response) => {
                            console.log(file);
                            $('#'+uuid+' div.dz-preview').remove();
                            this.removeAllFiles();
                            if(document.querySelector(dr.dataset.target).dataset.current){
                                let images = JSON.parse(document.querySelector(dr.dataset.target).dataset.current);
                                images.map(cur => {
                                    let mock = {name: cur.image, type: 'image/*'};
                                    this.displayExistingFile(mock, document.querySelector(dr.dataset.target).dataset.asset+cur.image);
                                    this.options.thumbnail.call(this, mock, document.querySelector(dr.dataset.target).dataset.asset+cur.image);
                                });
                            }
                            Array.from(response).forEach(file => {
                                console.log('array loop');
                                let mock = {name: file.file_name, size: file.size, type: file.type};
                                this.displayExistingFile(mock, file.url);
                            });
                            document.querySelector(dr.dataset.target).value = JSON.stringify(response);
                        });
                        this.on("removedfile", (file) => {
                            //Hacemos petición para eliminar la relación
                            axios.post(dr.dataset.deleteRoute, {image: file.name})
                            .then(response => {
                                console.log(response);
                            })
                            .catch(err => { console.error(error) });
                        });
                        // this.on("canceled", (f) => {
                        //     console.log('entra canceled');
                        // });
                    }
                });
            }else{
                //Creamos una instancia unica para dropzone instanciado en la vista
                let uuid = dr.getAttribute('id');
                console.log(uuid);
                var myDropzone = new Dropzone('#'+uuid, {
                    url: dr.dataset.route,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    uploadMultiple: false,
                    hiddenInputContainer: "div#"+uuid,
                    maxFiles: 1,
                    addRemoveLinks: true,
                    acceptedFiles: 'image/*',
                    dictDefaultMessage: 'Drop image here (or click) to capture/upload',
                    dictRemoveFile: "Remover archivo",
                    init: function() {
                        var curr = this;
                        instances[uuid] = this;
                        // if(document.querySelector('.select-uploaded')){
                            
                        // }
                        if(document.getElementById('modal-media')){
                            $("#modal-media").on('show.bs.modal', function(e){
                                if(e.relatedTarget.dataset.reference){
                                    let uuid = e.relatedTarget.dataset.reference;
                                    LoaderRod.show();
                                    axios.get(document.getElementById('modal-media').dataset.route)
                                    .then(response => {
                                        if(response.data.success){
                                            document.querySelector('.row.modal-media').innerHTML = response.data.files.map((file, i) => {
                                                return `
                                                <div class="col-sm-3">
                                                    <a href="javascript:;" class="select-uploaded" data-path="${file.path}" data-name="${file.name}" data-type="${file.type}" data-size="${file.size}" data-target="${i}-media">
                                                        <div class="card clickble">
                                                            <img id="${i}-media" class="card-img" src="${file.url}" alt="Card image">
                                                        </div>
                                                    </a>
                                                </div>`;
                                            }).join("");
                                        }
                                        LoaderRod.destroy();
                                        let uploads = document.querySelectorAll('.select-uploaded');
                                        Array.from(uploads).forEach(up => {
                                            up.addEventListener('click', e => {
                                                $('#'+uuid+' div.dz-preview').remove();
                                                dr = document.getElementById(uuid);
                                                let mock = {name: up.dataset.name, size: up.dataset.size, type: up.dataset.type};
                                                instances[uuid].displayExistingFile(mock, document.getElementById(up.dataset.target).getAttribute('src'));
                                                $('#modal-media').modal('hide');
                                                console.log(dr);
                                                document.querySelector(dr.dataset.target).value = up.dataset.path;
                                            });
                                        });
                                    })
                                    .catch(err => {
                                        console.log(err);
                                    });
                                }else{
                                    console.error('data-reference on anchor is missing');
                                }
                            });
                        }
                        if(document.querySelector(dr.dataset.target).value){
                            let mock = {name: document.querySelector(dr.dataset.target).value, type: 'image/*'};
                            // this.addFile.call(this, mock);
                            this.displayExistingFile(mock, document.querySelector(dr.dataset.target).dataset.asset+document.querySelector(dr.dataset.target).value);
                            // this.options.thumbnail.call(this, mock, document.querySelector(dr.dataset.target).dataset.asset+document.querySelector(dr.dataset.target).value);
                        }
                        this.on("success", (file, response) => {
                            $('#'+uuid+' div.dz-preview').remove();
                            this.removeAllFiles();
                            console.log(response);
                            let mock = {name: response.file_name, size: response.size, type: response.type};
                            console.log(mock);
                            // this.addFile.call(this, mock);
                            this.displayExistingFile(mock, response.url);
                            document.querySelector(dr.dataset.target).value = response.file_name;
                        });
                        this.on("removedfile", (file) => {
                            document.querySelector(dr.dataset.target).value = '';
                        });
                        // this.on("canceled", (f) => {
                        //     console.log('entra canceled');
                        // });
                    }
                });
            }
        })
    }
})();