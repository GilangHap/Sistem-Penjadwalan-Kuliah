<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?=base_url('jadwal')?>">Jadwal</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kalender Jadwal</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-calendar-alt me-2"></i>Kalender Jadwal
                    </h6>
                    <div>
                        <a href="<?= base_url('jadwal') ?>" class="btn btn-secondary">
                            <i class="fas fa-list me-1"></i> Daftar Jadwal
                        </a>
                        <a href="<?= base_url('jadwal/add') ?>" class="btn btn-primary ms-2">
                            <i class="fas fa-plus me-1"></i> Tambah Jadwal
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="btn-group" id="calendar-view-options">
                                <button type="button" class="btn btn-outline-primary active" data-view="timeGridWeek">Minggu</button>
                                <button type="button" class="btn btn-outline-primary" data-view="dayGridMonth">Bulan</button>
                                <button type="button" class="btn btn-outline-primary" data-view="timeGridDay">Hari</button>
                                <button type="button" class="btn btn-outline-primary" data-view="listWeek">List</button>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="legend">
                                <span class="badge rounded-pill bg-primary me-2">
                                    <i class="fas fa-circle me-1"></i>Semester Ganjil
                                </span>
                                <span class="badge rounded-pill bg-success">
                                    <i class="fas fa-circle me-1"></i>Semester Genap
                                </span>
                            </div>
                        </div>
                    </div>
                    <div id="calendar" style="height: 650px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if FullCalendar is loaded and calendar element exists
    if (typeof FullCalendar === 'undefined') {
        console.error('FullCalendar is not loaded');
        return;
    }

    var calendarEl = document.getElementById('calendar');
    if (!calendarEl) {
        console.error('Calendar element not found');
        return;
    }
    
    // Prepare events array
    var events = [];
    
    <?php foreach($jadwal_list as $jadwal): ?>
    <?php
        $days = ['Senin' => 1, 'Selasa' => 2, 'Rabu' => 3, 'Kamis' => 4, 'Jumat' => 5, 'Sabtu' => 6, 'Minggu' => 0];
        $dayNumber = isset($days[$jadwal->hari]) ? $days[$jadwal->hari] : 1;
        
        $eventColor = $jadwal->semester == 'Ganjil' ? '#4e73df' : '#1cc88a';

        $sks_time_mapping = [
            1 => ['07:00:00', '07:55:00'],
            2 => ['07:55:00', '08:50:00'],
            3 => ['08:50:00', '09:45:00'],
            4 => ['09:45:00', '10:40:00'],
            5 => ['10:40:00', '11:35:00'],
            6 => ['11:35:00', '12:30:00'],
            7 => ['12:30:00', '13:25:00'],
            8 => ['13:25:00', '14:20:00'],
            9 => ['14:20:00', '15:15:00'],
            10 => ['15:15:00', '16:10:00'],
            11 => ['16:10:00', '17:05:00'],
            12 => ['17:05:00', '18:00:00']
        ];
        
        $startSksKey = isset($jadwal->sks_ke) ? (int)$jadwal->sks_ke : 1;
        $startSksKey = array_key_exists($startSksKey, $sks_time_mapping) ? $startSksKey : 1;
        
        $jumlahSks = isset($jadwal->jumlah_sks) ? (int)$jadwal->jumlah_sks : 2;
        $endSksKey = $startSksKey + ($jumlahSks - 1);
        $endSksKey = min($endSksKey, 12);
        
        $startTime = $sks_time_mapping[$startSksKey][0];
        $endTime = $sks_time_mapping[$endSksKey][1];
        
        $displayStartTime = substr($startTime, 0, 5);
        $displayEndTime = substr($endTime, 0, 5);
    ?>
    events.push({
        id: '<?= $jadwal->id_jadwal ?>',
        title: '<?= addslashes($jadwal->nama_matkul) ?> (<?= addslashes($jadwal->kelas) ?>)',
        color: '<?= $eventColor ?>',
        daysOfWeek: [<?= $dayNumber ?>],
        startTime: '<?= $startTime ?>',
        endTime: '<?= $endTime ?>',
        startRecur: '2025-01-01',
        endRecur: '2025-12-31',
        extendedProps: {
            semester: '<?= $jadwal->semester ?>',
            description: '<div class="fc-event-details">' +
                '<p><strong>Dosen:</strong> <?= addslashes($jadwal->nama_dosen) ?></p>' +
                '<p><strong>Mata Kuliah:</strong> <?= addslashes($jadwal->nama_matkul) ?></p>' +
                '<p><strong>Kelas:</strong> <?= addslashes($jadwal->kelas) ?></p>' +
                '<p><strong>Ruang:</strong> <?= addslashes($jadwal->kode_ruang) ?></p>' +
                '<p><strong>Waktu:</strong> <?= $displayStartTime ?> - <?= $displayEndTime ?> (<?= $jumlahSks ?> SKS)</p>' +
                '<p><strong>Semester:</strong> <?= $jadwal->semester ?></p>' +
                '<p><strong>Tahun Ajaran:</strong> <?= addslashes($jadwal->tahun_ajaran) ?></p>' +
                '</div>'
        }
    });
    <?php endforeach; ?>
    
    // Initialize the calendar
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: '' 
        },
        events: events,
        slotMinTime: '07:00:00',
        slotMaxTime: '18:00:00',
        slotDuration: '00:15:00',
        allDaySlot: false,
        weekends: true, 
        hiddenDays: [0], 
        firstDay: 1, 
        height: '650px',
        navLinks: true,
        nowIndicator: true,
        locale: 'id', 
        businessHours: {
            daysOfWeek: [1, 2, 3, 4, 5, 6], 
            startTime: '07:00',
            endTime: '18:00'
        },
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        },
        eventDidMount: function(info) {
            try {
                var tooltip = new bootstrap.Tooltip(info.el, {
                    title: info.event.extendedProps.description,
                    placement: 'top',
                    trigger: 'hover',
                    container: 'body',
                    html: true,
                    customClass: 'fc-tooltip'
                });
            } catch (e) {
                console.error('Error creating tooltip:', e);
            }
        },
        eventClick: function(info) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: info.event.title,
                    html: info.event.extendedProps.description,
                    icon: 'info',
                    showCloseButton: true,
                    confirmButtonText: 'Tutup',
                    footer: '<a href="' + '<?= base_url('jadwal/edit/') ?>' + info.event.id + '" class="btn btn-warning btn-sm"><i class="fas fa-edit me-1"></i>Edit Jadwal</a>'
                });
            } else {
                alert(info.event.title);
            }
        }
    });
    
    calendar.render();
    
    document.querySelectorAll('#calendar-view-options button').forEach(function(button) {
        button.addEventListener('click', function() {
            var viewType = this.getAttribute('data-view');
            calendar.changeView(viewType);
            
            document.querySelectorAll('#calendar-view-options button').forEach(function(btn) {
                btn.classList.remove('active');
            });
            this.classList.add('active');
        });
    });
});
</script>