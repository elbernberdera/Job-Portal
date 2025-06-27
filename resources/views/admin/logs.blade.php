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
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Activity Logs</h3>
                    <a href="{{ route('admin.logs.export') }}" class="btn btn-success">
                        <i class="fas fa-download"></i> Export to Excel
                    </a>
                </div>
            </div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="logs">
                    <thead>
                        <tr>
                        <th>User</th>
                    <th>Email</th>
                    <th>IP Address</th>
                    <th>Device</th>
                    <th>Login Time </th>
                    <th>Logout Time </th>
                    <th>Role</th>
                    <th>Activity</th>
                            

                        </tr>
                    </thead>
                    <tbody id="logs-table-body">
                    @include('admin.partials.logs_table', ['logs' => $logs])
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

<script>
setInterval(function() {
    fetch("{{ route('admin.logs.ajax') }}")
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(html => {
            document.getElementById('logs-table-body').innerHTML = html;
        })
        .catch(error => {
            console.error('Error updating logs:', error);
        });
}, 5000); // 5 seconds
</script>
@endsection



