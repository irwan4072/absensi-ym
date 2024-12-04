$(document).ready(function() {
    // Fungsi untuk mengirim data saat elemen select atau input date berubah
function updateKehadiran() {
    const bulan = $('#date').val();
    const sanggarHadir = $('#sanggarHadir').val();

    $.ajax({
        url: "/kehadiran/index",
        type: 'post',
        data: {
            bulan: bulan,
            sanggarHadir: sanggarHadir
        },
        success: function() {
            document.location.href = '/kehadiran/index/' + bulan+'/'+sanggarHadir;
        }
    });
}

// Event listener untuk elemen input date dan select
$('#date, #sanggarHadir').on('change', function() {
    updateKehadiran();
});

// Event listener untuk file input agar nama file ditampilkan
$(".custom-file-input").on('change', function() {
    let fileName = $(this).val().split('\\').pop();
    console.log(fileName);
    $(this).next('.custom-file-label').addClass('selected').html(fileName);
});

$('.toggle-status').click(function() {
    var button = $(this);
    var id = button.data('id');
    var status = button.text().trim();
    // console.log(id);
    
    var newStatus = status == 'Aktifkan' ? 'Aktif' : 'Non Aktif';
    var newStatusTombol = status == 'Aktifkan' ? 'Non AktifKan' : 'Aktifkan';
    
    // console.log(newStatus);

    var confirmMessage = 'Apakah Anda yakin ingin mengubah status menjadi ' + newStatus + '?';

    if (confirm(confirmMessage)) {
        $.ajax({
            url: '/admin/toggle_status',
            type: 'POST',
            data: {
                id: id
            },
            success: function(response) {
                // console.log(response);
                // if (response.success) {
                    button.text(newStatus);
                    if (newStatus === 'Aktif') {
                      button.removeClass('btn-primary').addClass('btn-danger');
                    } else {
                      button.removeClass('btn-danger').addClass('btn-primary');
                    }
                    button.text(newStatusTombol);
                // } else {
                    // alert('Gagal mengubah status');
                // }
            },
            error: function() {
                console.error(xhr, status, error); 
                alert('Terjadi kesalahan');
            }
        });
    }
});

$('#telepon').on('keypress', function(event) {
    // Hanya izinkan angka
    if (event.which < 48 || event.which > 57) {
        event.preventDefault();
    }
});

$('.password-toggle').on('click', function() {
    var target = $(this).data('target');
    var input = $(target);
    var icon = $(this).find('i');

    if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        icon.removeClass('bi-eye-slash').addClass('bi-eye');
    } else {
        input.attr('type', 'password');
        icon.removeClass('bi-eye').addClass('bi-eye-slash');
    }
});











});

$(document).ready(function() {
    function checkStatus() {
        $.ajax({
            url: '/kegiatan/updateStatusKegiatan',
            method: 'GET',
            success: function(response) {
                // if (response.status === 'success') {
                //     location.reload(); // Reload halaman untuk memperbarui daftar kegiatan
                // }
            }
        });
    }

    // Set interval untuk memeriksa status setiap 10 detik
    setInterval(checkStatus, 10000);
});
