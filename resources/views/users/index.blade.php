@extends('layouts.app')

@section('content')

<div class="container" style="max-width: 1200px;">

    <!-- Header -->
    <div class="att-header">
        <h1>Admins</h1>
        <div class="header-line"></div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="flash-msg flash-success mb-4">{{ session('success') }}</div>
    @endif
    @if(session('failed'))
        <div class="flash-msg flash-danger mb-4">{{ session('failed') }}</div>
    @endif

    <!-- Create User Form -->
    <div class="filter-card mb-4">
        <p class="filter-label" style="margin-bottom: 18px;">Create New Admin</p>
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="filter-label">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter name" required>
                </div>
                <div class="col-md-4">
                    <label class="filter-label">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter email" required>
                </div>
                <div class="col-md-4">
                    <label class="filter-label">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Enter password" required>
                </div>
                <div class="col-12 d-flex align-items-center justify-content-between">
                    <label class="admin-check-label">
                        <input type="checkbox" value="1" name="isAdmin" class="admin-checkbox">
                        <span>Grant Super Admin privileges</span>
                    </label>
                    <button type="submit" class="btn-filter">Create Admin</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="table-wrapper">
        <table class="table table-bordered table-hover" id="usersTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Super Admin</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->is_admin)
                                <span class="badge bg-info">Yes</span>
                            @else
                                <span style="color:var(--muted); font-size:0.78rem;">No</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<style>
    .flash-msg {
        font-family: 'Syne', sans-serif;
        font-size: 0.78rem;
        font-weight: 600;
        padding: 12px 18px;
        border-radius: 8px;
        border: 1px solid transparent;
    }
    .flash-success {
        background: rgba(34,211,165,0.1);
        border-color: rgba(34,211,165,0.25);
        color: var(--success);
    }
    .flash-danger {
        background: rgba(247,92,110,0.1);
        border-color: rgba(247,92,110,0.25);
        color: var(--danger);
    }
    .admin-check-label {
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: 'Syne', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        color: var(--text-soft);
        cursor: pointer;
    }
    .admin-checkbox {
        width: 16px;
        height: 16px;
        accent-color: var(--accent);
        cursor: pointer;
    }
    .btn-delete {
        background: rgba(247,92,110,0.12);
        color: var(--danger);
        border: 1px solid rgba(247,92,110,0.25);
        border-radius: 7px;
        font-family: 'Syne', sans-serif;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 5px 14px;
        cursor: pointer;
        transition: background 0.2s, border-color 0.2s;
    }
    .btn-delete:hover {
        background: rgba(247,92,110,0.25);
        border-color: var(--danger);
    }
</style>

@endsection

@section('scripts')
<script>
$(document).ready(function () {
    $('#usersTable').DataTable({
        dom: '<"row"<"col-md-6"i><"col-md-6"f>>t<"row"<"col-md-6"B><"col-md-6"p>>',
        buttons: ['excel', 'pdf', 'csv', 'pageLength'],
        pageLength: 25,
        lengthMenu: [10, 25, 50, { label: 'All', value: -1 }],
        order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: 3 } // disable sort on Action column
        ]
    });
});
</script>
@endsection

