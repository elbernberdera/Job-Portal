@extends('admin.base.base')


@section('main_content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">logs</h3>
            </div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="user_Table">
                    <thead>
                        <tr>
                        <th>User</th>
                    <th>Email</th>
                    <th>IP Address</th>
                    <th>Device</th>
                    <th>Login Time </th>
                    <th>Logout Time </th>
                            

                        </tr>
                    </thead>
                    <tbody>
                    @forelse($logs as $log)
                <tr>
                    <td>{{ $log->user_name }}</td>
                    <td>{{ $log->email }}</td>
                    <td>{{ $log->ip_address }}</td>
                    <td>{{ $log->device }}</td>
                    <td>{{ $log->login_at ? \Carbon\Carbon::parse($log->login_at)->timezone('Asia/Manila')->format('Y-m-d H:i:s') : '' }}</td>
                    <td>{{ $log->logout_at ? \Carbon\Carbon::parse($log->logout_at)->timezone('Asia/Manila')->format('Y-m-d H:i:s') : '' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No activity logs found.</td>
                </tr>
                @endforelse
                    </tbody>
                </table>
            </div>
            


            </div>
        </div>
    </div>
</div>




<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

<script>
    $(document).ready(function () {
            $('#logs').DataTable({
                dom: 'Bfrtip',
                buttons: [
                     'pdf', 'print'
                ],
                responsive: true,
                pageLength: 10,
                order: [[0, 'asc']]
            });
        
    });
    
</script>
@endsection



