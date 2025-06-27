@forelse($logs as $log)
<tr>
    <td>{{ $log->user_name }}</td>
    <td>{{ $log->email }}</td>
    <td>{{ $log->ip_address }}</td>
    <td>{{ $log->device }}</td>
    <td>{{ $log->login_at ? \Carbon\Carbon::parse($log->login_at)->timezone('Asia/Manila')->format('Y-m-d H:i:s') : '' }}</td>
    <td>{{ $log->logout_at ? \Carbon\Carbon::parse($log->logout_at)->timezone('Asia/Manila')->format('Y-m-d H:i:s') : '' }}</td>
    <td>
        @if($log->role == 1)
            Admin
        @elseif($log->role == 2)
            HR
        @elseif($log->role == 3)
            User
        @else
            -
        @endif
    </td>
    <td>{{ $log->activity ?? '-' }}</td>
</tr>
@empty
<tr>
    <td colspan="8" class="text-center">No activity logs found.</td>
</tr>
@endforelse 