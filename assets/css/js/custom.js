$(document).ready(function() {
    // Navbar Scroll Effect
    $(window).scroll(function() {
        if ($(window).scrollTop() > 50) {
            $('.navbar').addClass('navbar-scrolled');
        } else {
            $('.navbar').removeClass('navbar-scrolled');
        }
    });
    
    // Initialize DataTables dengan pengecekan
    $('.data-table').each(function() {
        if (!$.fn.DataTable.isDataTable(this)) {
            $(this).DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                },
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                     "<'row'<'col-sm-12'tr>>" +
                     "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                pageLength: 10,
                responsive: true,
                destroy: true // Hancurkan instance sebelumnya jika ada
            });
        }
    });
    
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    
    // Smooth scroll to alert
    if($('.alert').length) {
        $('html, body').animate({
            scrollTop: $('.alert').offset().top - 100
        }, 500);
    }
    
    // Form validation
    $('.needs-validation').each(function() {
        $(this).on('submit', function(event) {
            if (!this.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            $(this).addClass('was-validated');
        });
    });
    
    // Initialize FullCalendar if available
    if(document.getElementById('calendar')) {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            locale: 'id',
            events: {
                url: BASE_URL + 'jadwal/get_events',
                failure: function() {
                    alert('Error fetching events!');
                }
            },
            eventColor: '#0d6efd',
            eventClick: function(info) {
                // Handle event click
                var event = info.event;
                if(event.url) {
                    window.open(event.url);
                    return false;
                }
            }
        });
        calendar.render();
    }
    
    // Confirm delete action
    $('.btn-delete').on('click', function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        
        // Using SweetAlert if available, otherwise use native confirm
        if(typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            });
        } else {
            if(confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                window.location.href = href;
            }
        }
    });
});