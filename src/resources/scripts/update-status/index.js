import Toast from '../Toast';
import Swal from 'sweetalert2';
// import axios from 'axios';

export default(function(){
    //Obtenemos todos los inputs con la clase update-status
    let inputs = document.querySelectorAll('.update-status');
    Array.from(inputs).forEach(inp => {
        inp.addEventListener('change', e => {
            let data
            if(inp.checked == true){
                data = {status: 'visible', api: true}
            }else{
                data = {status: 'hidden', api: true}
            }
            axios.put(inp.dataset.route, data)
            .then(response => {
                if((response.status == 200) && (response.data.success)){
                    proceed(inp);
                }else{
                    Swal.fire('¡Ups!', 'Lo sentimos, algo salió mal', 'error');
                }
            })
            .catch(err => {
                Swal.fire('¡Ups!', 'Lo sentimos, algo salió mal', 'error');
                throw new Error('Something went wrong', err);
            });
        })
    });
    const proceed = (inp) => {
        Toast.fire({
            icon: 'success',
            title: '¡Correcto! Elemento actualizado'
        });

        if(inp.dataset.action){
            window.setTimeout(() => {
                eval(inp.dataset.action);                                            
            }, 1000);
        }
    }
})();