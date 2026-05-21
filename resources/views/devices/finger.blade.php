@extends('layouts.app')

@section('content')

<div class="container" style="max-width: 1200px;">

    <!-- Header -->
    <div class="att-header">
        <h1>Log Finger</h1>
        <div class="header-line"></div>
    </div>

    <!-- Table -->
    <div class="table-wrapper">
        <table class="table table-bordered table-hover" id="fingers-log">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

</div>

@endsection

