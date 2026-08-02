import Alpine from 'alpinejs';
import axios from 'axios';
import Swal from 'sweetalert2';
import '../css/app.css';
import '@fortawesome/fontawesome-free/css/all.min.css';

window.Alpine = Alpine;
window.axios = axios;
window.Swal = Swal;
Alpine.start();


window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}
