import Swal from 'sweetalert2';

export default (function(){
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
    let buttons = document.querySelectorAll('.btn-delete');
    Array.from(buttons).forEach((btn) => {
        btn.addEventListener('click', e => {
            Swal.fire({
                title: '¿Está seguro?',
                text: "Este registro se eliminará",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, confirmar",
                cancelButtonText: "No, cancelar",
            }).then((result) => {
                if(result.value){
                    if(btn.dataset.axiosMethod){
                        switch (btn.dataset.axiosMethod) {
                            case 'put':
                                axios.put(btn.dataset.route)
                                .then(response => {
                                    if((response.status == 200) && (response.data.success)){
                                        proceed(btn);
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
                                        proceed(btn);
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
            })
        })
    });
    const proceed = (btn) => {
        Toast.fire({
            icon: 'success',
            title: '¡Correcto! Operación exitosa'
        });

        if(btn.dataset.action){
            window.setTimeout(() => {
                eval(btn.dataset.action);                                            
            }, 1000);
        }else{
            window.setTimeout(() => {
                location.reload();
            }, 200);
        }
    }
})();