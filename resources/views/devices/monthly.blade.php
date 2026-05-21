@extends('layouts.app')

@section('content')

<div class="container" style="max-width: 1200px;">

    <!-- Header -->
    <div class="att-header">
        <h1>Monthly Attendance</h1>
        <div class="header-line"></div>
    </div>

    <!-- Filter Card -->
    <div class="filter-card">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="filter-label">Start Date</label>
                <input type="date" id="start_date" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="filter-label">End Date</label>
                <input type="date" id="end_date" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="filter-label">Employee ID</label>
                <input type="text" id="employee_id" class="form-control" placeholder="Search ID…">
            </div>
            <div class="col-md-3">
                <label class="filter-label">Employee Name</label>
                <input type="text" id="employee_name" class="form-control" placeholder="Search name…">
            </div>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-3">
            <button id="filter_button" class="btn-filter">Show Employee Records</button>
            <button id="show_all_button" class="btn-filter" style="background: var(--success); box-shadow: 0 4px 18px rgba(34,211,165,0.2);">Show All Employees</button>
        </div>
    </div>

    <!-- Table -->
    <div class="table-wrapper">
        <table class="table table-bordered table-hover" id="attendanceTable">
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Date</th>
                    <th>Total Hours</th>
                </tr>
            </thead>
        </table>
    </div>

</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {
    var table = $('#attendanceTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: "{{ route('devices.getMonthlyAttendanceSummary') }}",
            data: function (d) {
                d.start_date    = $('#start_date').val();
                d.end_date      = $('#end_date').val();
                d.employee_id   = $('#employee_id').val();
                d.employee_name = $('#employee_name').val();
                d.all_employees = $('#show_all_button').data('clicked') ? 1 : 0;
            }
        },
        dom: '<"row"<"col-md-6"l><"col-md-6"f>>rtip<"row"<"col-md-6"B>>',
        buttons: ['excel', 'pdf', 'csv'],
        columns: [
            { data: 'employee_id',   name: 'employee_id' },
            { data: 'employee_name', name: 'employee_name' },
            { data: 'date',          name: 'date',        defaultContent: '-' },
            { data: 'total_hours',   name: 'total_hours', defaultContent: '-' },
        ],
        order: [[2, 'asc']]
    });

    $('#filter_button').click(function () {
        $('#show_all_button').data('clicked', false);
        if (!$('#start_date').val() || !$('#end_date').val()) {
            alert('Please select start and end dates.');
            return;
        }
        table.ajax.reload();
    });

    $('#show_all_button').click(function () {
        $('#show_all_button').data('clicked', true);
        $('#employee_id').val('');
        $('#employee_name').val('');
        if (!$('#start_date').val() || !$('#end_date').val()) {
            alert('Please select start and end dates.');
            return;
        }
        table.ajax.reload();
    });

    // Default to current month
    var today          = new Date();
    var firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
    $('#start_date').val(firstDayOfMonth.toISOString().split('T')[0]);
    $('#end_date').val(today.toISOString().split('T')[0]);
});
</script>
@endsection

