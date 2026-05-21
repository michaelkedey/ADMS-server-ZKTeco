@extends('layouts.app')

@section('content')

<div class="container" style="max-width: 1200px;">

    <!-- Header -->
    <div class="att-header">
        <h1>{{ $label ?? 'Devices' }}</h1>
        <div class="header-line"></div>
    </div>

    <!-- Table -->
    <div class="table-wrapper">
        <table class="table table-bordered table-hover" id="devices">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Serial Number</th>
                    <th>Status</th>
                    <th>Last Online</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($log as $d)
                <tr>
                    <td>{{ $d->device_name ?? 'N/A' }}</td>
                    <td>{{ $d->no_sn }}</td>
                    <td>
                        @php
                            $lastSeen = \Carbon\Carbon::parse($d->online);
                            $isOnline = $lastSeen->diffInMinutes(now()) <= 1;
                        @endphp
                        @if($isOnline)
                            <span class="badge bg-success">Online</span>
                        @else
                            <span class="badge bg-danger">Offline</span>
                        @endif
                    </td>
                    <td>{{ $d->online ?? 'N/A' }}</td>
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
    $('#devices').DataTable({
        dom: '<"row"<"col-md-6"f>>t<"row"<"col-md-6"B>>',
        buttons: ['excel', 'pdf', 'csv', 'pageLength'],
        pageLength: 50,
        lengthMenu: [25, 50, 100, { label: 'All', value: -1 }],
        order: [[1, 'asc']],
    });
});
</script>
@endsection

