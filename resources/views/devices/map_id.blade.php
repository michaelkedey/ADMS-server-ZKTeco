@extends('layouts.app')

@section('content')

<div class="container" style="max-width: 1200px;">

    <!-- Header -->
    <div class="att-header">
        <h1>Map Employee</h1>
    </div>

    <!-- Form Card -->
    <div class="filter-card mb-4">
        <p class="filter-label" style="margin-bottom: 18px;">Map Employee ID with Names</p>
        <p style="font-size:0.78rem; color:var(--muted); margin-bottom: 18px; margin-top: -10px;">
            Providing the same ID will replace the existing name of the employee.
        </p>
        <form action="{{ route('employee.store') }}" method="POST">
            @csrf
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="filter-label">Employee ID</label>
                    <input type="number" class="form-control" id="employee_id" name="employee_id"
                        placeholder="Enter Employee ID" required>
                </div>
                <div class="col-md-5">
                    <label class="filter-label">Employee Name</label>
                    <input type="text" class="form-control" id="employee_name" name="employee_name"
                        placeholder="Enter Employee Name" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn-filter w-100">Submit</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Employee Table -->
    <div class="table-wrapper">
        <table class="table table-bordered table-hover" id="employeeTable">
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                    <tr>
                        <td>{{ $employee->employee_id }}</td>
                        <td>
                            @if (!empty($employee->name))
                                {{ $employee->name }}
                            @else
                                <span style="color:var(--muted)">N/A</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {
    $('#employeeTable').DataTable({
        dom: '<"row"<"col-md-6"i><"col-md-6"f>>t<"row"<"col-md-6"B><"col-md-6"p>>',
        buttons: ['excel', 'pdf', 'csv', 'pageLength'],
        pageLength: 50,
        lengthMenu: [25, 50, 100, { label: 'All', value: -1 }],
        order: [[0, 'asc']],
    });
});
</script>
@endsection

