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
                    <div class="d-flex gap-2">
                        <!-- Date Selection Form -->
                        <form id="dateFilterForm" method="POST" action="{{ route('admin.logs.filter-by-date') }}" class="d-flex gap-2 align-items-center">
                            @csrf
                            <label for="selected_date" class="mb-0 font-weight-bold">Select Date:</label>
                            <input type="date" id="selected_date" name="selected_date" class="form-control" style="width: auto;" value="{{ $selectedDate ?? date('Y-m-d') }}">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                        </form>
                        
                        <!-- Export buttons -->
                        <div class="d-flex gap-2">
                            <button id="exportSelectedDate" class="btn btn-info" style="display: none;">
                                <i class="fas fa-download"></i> Export Selected Date
                            </button>
                            <a href="{{ route('admin.logs.export') }}" class="btn btn-success">
                                <i class="fas fa-download"></i> Export All
                            </a>
                            <button id="printSelectedDate" class="btn btn-warning" style="display: none;">
                                <i class="fas fa-print"></i> Print Selected Date
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if(isset($selectedDate))
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Showing logs for: <strong>{{ \Carbon\Carbon::parse($selectedDate)->format('F d, Y') }}</strong>
                        <a href="{{ route('admin.logs') }}" class="btn btn-sm btn-outline-secondary ml-2">Show All Logs</a>
                    </div>
                @endif
                
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-bordered table-striped mb-0" id="logs">
                        <thead class="bg-light" style="position: sticky; top: 0; z-index: 2;">
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
        // Initialize DataTable
        var table = $('#logs').DataTable({
            dom: 'Bfrtip',
            buttons: [
                 'pdf', 'print'
            ],
            responsive: true,
            pageLength: 10,
            order: [[0, 'asc']]
        });
        
        // Show/hide export and print buttons based on date selection
        function toggleDateButtons() {
            var selectedDate = $('#selected_date').val();
            if (selectedDate && selectedDate !== '') {
                $('#exportSelectedDate, #printSelectedDate').show();
            } else {
                $('#exportSelectedDate, #printSelectedDate').hide();
            }
        }
        
        // Initialize button visibility
        toggleDateButtons();
        
        // Update button visibility when date changes
        $('#selected_date').on('change', function() {
            toggleDateButtons();
        });
        
        // Export selected date
        $('#exportSelectedDate').on('click', function() {
            var selectedDate = $('#selected_date').val();
            if (selectedDate) {
                var form = $('<form>', {
                    'method': 'POST',
                    'action': '{{ route("admin.logs.export-by-date") }}'
                });
                
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': '_token',
                    'value': '{{ csrf_token() }}'
                }));
                
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'selected_date',
                    'value': selectedDate
                }));
                
                $('body').append(form);
                form.submit();
                form.remove();
            }
        });
        
        // Print selected date
        $('#printSelectedDate').on('click', function() {
            var selectedDate = $('#selected_date').val();
            if (selectedDate) {
                // Create a new window for printing
                var printWindow = window.open('', '_blank');
                var selectedDateFormatted = new Date(selectedDate).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                
                printWindow.document.write(`
                    <html>
                        <head>
                            <title>Activity Logs - ${selectedDateFormatted}</title>
                            <style>
                                body { font-family: Arial, sans-serif; margin: 20px; }
                                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                                th { background-color: #f2f2f2; font-weight: bold; }
                                .header { text-align: center; margin-bottom: 20px; }
                                .date-info { margin-bottom: 20px; font-weight: bold; }
                                @media print {
                                    .no-print { display: none; }
                                }
                            </style>
                        </head>
                        <body>
                            <div class="header">
                                <h2>Activity Logs Report</h2>
                                <div class="date-info">Date: ${selectedDateFormatted}</div>
                            </div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Email</th>
                                        <th>IP Address</th>
                                        <th>Device</th>
                                        <th>Login Time</th>
                                        <th>Logout Time</th>
                                        <th>Role</th>
                                        <th>Activity</th>
                                    </tr>
                                </thead>
                                <tbody id="print-table-body">
                                </tbody>
                            </table>
                            <div class="no-print" style="margin-top: 20px;">
                                <button onclick="window.print()">Print</button>
                                <button onclick="window.close()">Close</button>
                            </div>
                        </body>
                    </html>
                `);
                
                // Fetch and populate the data
                fetch('{{ route("admin.logs.ajax-by-date") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: 'selected_date=' + encodeURIComponent(selectedDate)
                })
                .then(response => response.text())
                .then(html => {
                    printWindow.document.getElementById('print-table-body').innerHTML = html;
                })
                .catch(error => {
                    console.error('Error fetching data for print:', error);
                    printWindow.document.getElementById('print-table-body').innerHTML = '<tr><td colspan="8">Error loading data</td></tr>';
                });
            }
        });
    });
</script>

@if(!isset($selectedDate))
<script>
    // Auto-refresh logs (only if no date is selected)
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
@endif
@endsection

 

