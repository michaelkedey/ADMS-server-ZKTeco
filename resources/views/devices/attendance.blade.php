@extends('layouts.app')

@section('content')

<div class="container" style="max-width: 1200px;">

    <!-- Header -->
    <div class="att-header">
        <h1>Attendance</h1>
    </div>

    <!-- Filter Card -->
    <div class="filter-card">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="filter-label">Start Date</label>
                <input type="date" id="start_date" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="filter-label">End Date</label>
                <input type="date" id="end_date" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="filter-label">Employee ID</label>
                <input type="text" id="employee_id_search" class="form-control" placeholder="Search ID…">
            </div>
            <div class="col-md-3">
                <label class="filter-label">Employee Name</label>
                <input type="text" id="employee_name_search" class="form-control" placeholder="Search name…">
            </div>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <button id="filter_button" class="btn-filter">Apply Filter</button>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="summary-grid">
        <div class="summary-card checkin">
            <div class="s-label">Total Check-ins</div>
            <div class="s-value" id="total_checkin">0</div>
            <div class="s-icon">→</div>
        </div>
        <div class="summary-card checkout">
            <div class="s-label">Total Check-outs</div>
            <div class="s-value" id="total_checkout">0</div>
            <div class="s-icon">←</div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-wrapper">
        <table class="table table-bordered table-hover" id="attendanceTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>SN</th>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Timestamp</th>
                    <th>Status</th>
                    <th>Type</th>
                </tr>
            </thead>
        </table>
    </div>

</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const today     = new Date().toISOString().split('T')[0];
    const yesterday = new Date(new Date().setDate(new Date().getDate() - 1)).toISOString().split('T')[0];

    document.getElementById('start_date').value = yesterday;
    document.getElementById('end_date').value   = today;
});

$(document).ready(function () {
    var table = $('#attendanceTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('devices.getAttendance') }}",
            data: function (d) {
                d.start_date    = $('#start_date').val();
                d.end_date      = $('#end_date').val();
                d.employee_id   = $('#employee_id_search').val();
                d.employee_name = $('#employee_name_search').val();
            },
            dataSrc: function(json) {
                let checkins  = json.data.filter(x => x.status1 == 0).length;
                let checkouts = json.data.filter(x => x.status1 == 1).length;
                $('#total_checkin').text(checkins);
                $('#total_checkout').text(checkouts);
                return json.data;
            }
        },
        dom: '<"row"<"col-md-6"i><"col-md-6"f>>t<"row"<"col-md-6"B><"col-md-6"p>>',
        buttons: ['excel', 'pdf', 'csv', 'pageLength'],
        searching: false,
        pageLength: 100,
        lengthMenu: [50, 100, 500, { label: 'All', value: -1 }],
        columns: [
            { data: 'id',            name: 'id' },
            { data: 'sn',            name: 'sn' },
            { data: 'employee_id',   name: 'employee_id' },
            { data: 'employee_name', name: 'employee_name' },
            {
                data: 'timestamp', name: 'timestamp',
                render: function (data) {
                    return new Date(data).toLocaleString('en-US', {
                        year: 'numeric', month: 'numeric', day: 'numeric',
                        hour: 'numeric', minute: 'numeric', hour12: true
                    });
                }
            },
            {
                data: 'status1', name: 'status1',
                render: function (data) {
                    if (data == 1) return '<span class="badge bg-danger">Out ⬅️</span>';
                    else           return '<span class="badge bg-success">In ➡️</span>';
                }
            },
            {
                data: 'status2', name: 'status2',
                render: function (data) {
                    if (data == 15) return '<span class="badge bg-info">Face</span>';
                    if (data == 25) return '<span class="badge bg-warning text-dark">Palm</span>';
                    return data;
                }
            },
        ],
        order: [[0, 'desc']]
    });

    $('#filter_button').click(function () { table.draw(); });
    $('#employee_id_search, #employee_name_search').on('keyup', function () { table.draw(); });
});
</script>
@endsection

