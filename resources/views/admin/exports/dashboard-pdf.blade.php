<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Tickets Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .filters {
            margin-bottom: 20px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Tickets Report</h1>
        <p>Generated on: {{ $exportDate }}</p>
        <p>Total Tickets: {{ $totalTickets }}</p>
    </div>

    @if(!empty(array_filter($filters)))
    <div class="filters">
        <h3>Applied Filters:</h3>
        <ul>
            @if(!empty($filters['user_id']))
            <li>User ID: {{ $filters['user_id'] }}</li>
            @endif
            @if(!empty($filters['day']))
            <li>Day: {{ $filters['day'] }}</li>
            @endif
            @if(!empty($filters['month']))
            <li>Month: {{ $filters['month'] }}</li>
            @endif
            @if(!empty($filters['category']))
            <li>Category: {{ $filters['category'] }}</li>
            @endif
            @if(!empty($filters['application']))
            <li>Application: {{ $filters['application'] }}</li>
            @endif
        </ul>
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Ticket ID</th>
                <th>User</th>
                <th>Category</th>
                <th>Application</th>
                <th>Company</th>
                <th>Branch</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
            <tr>
                <td>{{ $ticket->id }}</td>
                <td>{{ $ticket->user->name ?? 'N/A' }}</td>
                <td>{{ $ticket->category }}</td>
                <td>{{ $ticket->application }}</td>
                <td>{{ $ticket->company }}</td>
                <td>{{ $ticket->branch }}</td>
                <td>{{ $ticket->ticket_type }}</td>
                <td>{{ $ticket->created_at->format('d M Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>