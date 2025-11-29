<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Provider Report</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color: #111827; }
        h1 { font-size: 18px; margin: 0 0 8px; }
        p { margin: 0 0 6px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #E5E7EB; padding: 6px 8px; text-align: left; }
        th { background: #F8FAFC; font-weight: 600; font-size: 11px; text-transform: uppercase; color: #6B7280; }
        .muted { color: #6B7280; }
    </style>
    </head>
<body>
    <h1>Provider Report</h1>
    <p class="muted">
        Date Range (Created):
        {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('M d, Y') : '—' }}
        to
        {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('M d, Y') : '—' }}
    </p>
    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th>Specialty/Type</th>
                <th>Provider Name</th>
                <th>License Number</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    <td>{{ $item['category'] }}</td>
                    <td>{{ $item['specialty_type'] ?? '—' }}</td>
                    <td>{{ $item['provider_name'] ?? '—' }}</td>
                    <td>{{ $item['license_number'] ?? '—' }}</td>
                    <td>
                        @if($item['created_at'])
                            {{ $item['created_at']->format('M d, Y') }}
                        @else
                            —
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="muted">No data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>

