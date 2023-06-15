function showAlert(title, text, icon) {
    let timerInterval
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        html: 'Прозореца ще се затвори след <b></b> сек.',
        timer: 2000,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading()
            const b = Swal.getHtmlContainer().querySelector('b')
            timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft()
            }, 100)
        },
        willClose: () => {
            clearInterval(timerInterval)
        }
    }).then((result) => {
        if (result.dismiss === Swal.DismissReason.timer) {
            console.log('I was closed by the timer')
        }
    })
}

(() => {
    'use strict'

    document.querySelector('#navbarSideCollapse').addEventListener('click', () => {
        document.querySelector('.offcanvas-collapse').classList.toggle('open')
    })
})()

$(document).ready( function () {
    $('#datatable').DataTable();
} );