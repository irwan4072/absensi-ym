/*!
    * Start Bootstrap - SB Admin v7.0.5 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2022 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    // 
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});



// $(document).ready(function() {
//     $('#openModalButton').on('click', function(){
//         $.ajax({
//           url: 'kegiatan/modalKegiatan', // Ganti dengan URL controller dan method CodeIgniter Anda
//           type: 'POST',
//           data: { id_kegiatan: selectedValue },
//           success: function(response){
//             $('#myModal .modal-body').html(response);
//           },
//           error: function(){
//             $('#myModal .modal-body').html('<p>Terjadi kesalahan saat memuat konten.</p>');
//           }
//         });
//       });
//       $('#pesertaModal').click(function() {
//         var id = $(this).data('value');
//         var minuman = $(this).data('title');
//         console.log('ok');
//         // var minuman = $('#namaMinuman').val();
//         var judulPembelian = $('#judulStok').data('value');
//         $('#idMinumanTambahStok').val(id);
//         var title = judulPembelian + minuman
//         $('#judulStok').text(title);
//         // $('#exampleModal').modal('show');
//         // console.log(minuman);
//     });
// });
