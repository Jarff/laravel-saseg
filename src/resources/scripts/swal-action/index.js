import Swal from 'sweetalert2';
import LoaderRod from '../loader';

export default (() => {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        onOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    window.swalAction = function(btn){
        Swal.fire({
            title: btn.dataset.title,
            text: btn.dataset.text,
            icon: btn.dataset.swalIcon,
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar",
            showCancelButton: true,
        }).then((result) => {
            if(result.value){
                if(btn.dataset.axiosMethod){
                    // TODO:
                    //Instanciate the loader
                    LoaderRod.show();
                    let body = {};
                    if(btn.dataset.axiosBody)
                        body = JSON.parse(btn.dataset.axiosBody.toString());
                    switch (btn.dataset.axiosMethod) {
                        case 'put':
                            axios.put(btn.dataset.route, body)
                            .then(response => {
                                if((response.status == 200) && (response.data.success)){
                                    Toast.fire("Correcto", "Operación exitosa");
                                    eval(btn.dataset.action);  
                                }else{
                                    Swal.fire('¡Ups!', 'Lo sentimos, algo salió mal', 'error');
                                }
                            })
                            .catch(err => {
                                Swal.fire('¡Ups!', 'Lo sentimos, algo salió mal', 'error');
                                throw new Error('Something went wrong', err);
                            });
                        break;
                        case 'post':
                            axios.post(btn.dataset.route)
                            .then(response => {
                                if((response.status == 200) && (response.data.success)){
                                    eval(btn.dataset.action);  
                                }else{
                                    Swal.fire('¡Ups!', 'Lo sentimos, algo salió mal', 'error');
                                }
                            })
                            .catch(err => {
                                Swal.fire('¡Ups!', 'Lo sentimos, algo salió mal', 'error');
                                throw new Error('Something went wrong', err);
                            });
                        break;
                        case 'get':
                            axios.get(btn.dataset.route)
                            .then(response => {
                                if((response.status == 200) && (response.data.success)){
                                    eval(btn.dataset.action);  
                                }else{
                                    Swal.fire('¡Ups!', 'Lo sentimos, algo salió mal', 'error');
                                }
                            })
                            .catch(err => {
                                Swal.fire('¡Ups!', 'Lo sentimos, algo salió mal', 'error');
                                throw new Error('Something went wrong', err);
                            });
                        break;
                        case 'delete':
                            axios.delete(btn.dataset.route)
                            .then(response => {
                                if((response.status == 200) && (response.data.success)){
                                    eval(btn.dataset.action);  
                                }else{
                                    Swal.fire('¡Ups!', 'Lo sentimos, algo salió mal', 'error');
                                }
                            })
                            .catch(err => {
                                Swal.fire('¡Ups!', 'Lo sentimos, algo salió mal', 'error');
                                throw new Error('Something went wrong', err);
                            });
                        break;
                        default:
                            break;
                    }
                }
            }
        });
    }

    // let buttons = document.querySelectorAll('.btn-action');
    // console.log('buttons: ', buttons);
    // Array.from(buttons).forEach((btn) => {
    //     console.log('entra');
    //     btn.addEventListener('click', e => {
    //         console.log('click al boton');

    //     });
    // });
})();