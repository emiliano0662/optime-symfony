import './scss/style.scss';
import * as bootstrap from 'bootstrap';
import Swal from 'sweetalert2';

$('.alert').each(function() {
    setTimeout(function(){ $('.alert').hide(); }, 5000);
});

$(document).on('click', '.btn-prevent-delete', function (event) {
    event.preventDefault();

    var href = $(this).attr('href');

    Swal.fire({
        title: 'Estas seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Sí, bórralo',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = href;
        }
    })
});