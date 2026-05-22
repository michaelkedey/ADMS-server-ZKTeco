@extends('layouts.app')

@section('content')

<div class="container" style="max-width: 1200px;">

    <!-- Header -->
    <div class="att-header">
        <h1>Daily Attendance</h1>
    </div>

    <!-- Filter Card -->
    <div class="filter-card">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="filter-label">Date</label>
                <input type="date" id="date" class="form-control">
            </div>
            <div class="col-md-3">
                <button id="filter_button" class="btn-filter w-100">Show Records</button>
            </div>
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
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Total Time</th>
                </tr>
            </thead>
        </table>
    </div>

</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const yesterday = new Date(new Date().setDate(new Date().getDate() - 1)).toISOString().split('T')[0];
    document.getElementById('date').max   = yesterday;
    document.getElementById('date').value = yesterday;
});

$(document).ready(function () {
    var table = $('#attendanceTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('devices.getDailyAttendanceSummary') }}",
            data: function (d) {
                d.start_date = $('#date').val();
            },
            dataSrc: function(json) {
                let checkins  = json.data.filter(x => x.first_in).length;
                let checkouts = json.data.filter(x => x.last_out && x.last_out != "No Checkout").length;
                $('#total_checkin').text(checkins);
                $('#total_checkout').text(checkouts);
                return json.data;
            }
        },
        dom: '<"row"<"col-md-6"f>>t<"row"<"col-md-6"B>>',
        buttons: ['excel', 'pdf', 'csv', 'pageLength'],
        searching: false,
        pageLength: 100,
        lengthMenu: [50, 100, 500, { label: 'All', value: -1 }],
        columns: [
            { data: 'employee_id',   name: 'employee_id' },
            { data: 'employee_name', name: 'employee_name' },
            {
                data: 'first_in', name: 'first_in',
                render: function(data) {
                    if (!data) return '<span class="badge bg-warning">No Check-in</span>';
                    return '<span class="badge bg-success">' + data + '</span>';
                }
            },
            {
                data: 'last_out', name: 'last_out',
                render: function(data) {
                    if (!data || data === "No Checkout") return '<span class="badge bg-danger">No Checkout</span>';
                    return '<span class="badge bg-info">' + data + '</span>';
                }
            },
            {
                data: 'total_time', name: 'total_time',
                render: function(data) {
                    return data || '<span style="color:var(--muted)">N/A</span>';
                }
            },
        ],
        order: [[0, 'asc']]
    });

    $('#filter_button').click(function () { table.draw(); });
});
</script>
@endsection

