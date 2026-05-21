@extends('layouts.app')

@section('content')

<div class="container" style="max-width: 1200px;">

    <!-- Header -->
    <div class="att-header">
        <h1>{{ $lable }}</h1>
        <div class="header-line"></div>
    </div>

    <!-- Table -->
    <div class="table-wrapper">
        <table class="table table-bordered table-hover" id="devices">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>URL</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($log as $d)
                    <tr>
                        <td>{{ $d->id }}</td>
                        <td style="word-break: break-all; font-size: 0.78rem;">{{ $d->url }}</td>
                        <td style="word-break: break-all; font-size: 0.78rem;">{{ $d->data }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-end" style="padding: 14px 20px;">
            {{ $log->links('pagination::bootstrap-5') }}
        </div>
    </div>

</div>

@endsection

