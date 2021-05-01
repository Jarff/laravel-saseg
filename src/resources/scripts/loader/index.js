class LoaderRod{
    constructor(){
        this.spinner_style = `
        position: absolute;
        top: 50%;
        left: 50%;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        margin-left: -12px;
        border: 2px solid rgba(255,255,255,0.2);
        border-top-color: #fff;
        -webkit-animation: spin 0.7s infinite linear;
        -moz-animation: spin 0.7s infinite linear;
        animation: spin 0.7s infinite linear;
        -webkit-transform: translate(-50%, -50%);
        -moz-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        -o-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);`
    }

    show(){
        var div = document.createElement('div');
        div.classList.add('ui-panorama-loader');
        div.setAttribute('id', 'preloader');
        div.setAttribute('style', 'top: 0;position: fixed;width: 100%;height: 100%;background-color: rgba(0,0,0,0.6);z-index: 9900;');
        var style = document.createElement('style');
        style.innerHTML = `
        @-webkit-keyframes spin{0%{-webkit-transform:rotate(0deg)}100%{-webkit-transform:rotate(360deg)}}@-moz-keyframes spin{0%{-moz-transform:rotate(0deg)}100%{-moz-transform:rotate(360deg)}}@keyframes spin{0%{-webkit-transform:rotate(0deg);-moz-transform:rotate(0deg);-ms-transform:rotate(0deg);-o-transform:rotate(0deg);transform:rotate(0deg)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-webkit-keyframes pulse{50%{background:#fff}}@-moz-keyframes pulse{50%{background:#fff}}@keyframes pulse{50%{background:#fff}}@-webkit-keyframes present{0%{margin-top:-70px}100%{opacity:1;margin-top:-35px}}@-moz-keyframes present{0%{margin-top:-70px}100%{opacity:1;margin-top:-35px}}@keyframes present{0%{margin-top:-70px}100%{opacity:1;margin-top:-35px}}@-webkit-keyframes present_spin{0%{opacity:0}100%{opacity:1}}@-moz-keyframes present_spin{0%{opacity:0}100%{opacity:1}}@keyframes present_spin{0%{opacity:0}100%{opacity:1}}
        `;
        document.querySelector('body').appendChild(div);
        document.querySelector('body').appendChild(style);
        document.getElementById('preloader').innerHTML = `
            <div class="ui-panorama-loader-layer" style="opacity:1;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);color: #fff;font-family: sans-serif;font-size: 12px;text-transform: uppercase;z-index: 9900;">
                <div class="ui-preloader-spinner" style="${this.spinner_style}"></div>
            </div>
        `;
    }

    destroy(){
        var loader = document.getElementById('preloader');
        document.querySelector('body').removeChild(loader);
    }
}

export default new LoaderRod();