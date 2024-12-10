<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invoice['title'] }}</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h3, p{
            color: #03B7EA;
        }
        
    </style>
</head>
<body>
    <h3>Hello {{ $invoice['name'] }},</h3>
    <p>Your invoice information is given below:</p>
    <table>
        <tr>
            <th>Invoice Number</th>
            <th>Job Name</th>
            <th>Invoice Date</th>
            <th>Amount</th>
            <th>Hour</th>
            <th>Total Amount</th>
        </tr>
        <tr>
            <td>{{ $invoice['invoice_number'] }}</td>
            <td>{{ $invoice['item_name'] }}</td>
            <td>
                @php
                    $invoiceDate = \Carbon\Carbon::parse($invoice['invoice_date']);
                @endphp
                {{ $invoiceDate->format('d/m/Y') }}
            </td>
            <td>${{ $invoice['amount'] }}</td>
            <td>{{ $invoice['hour'] }}</td>
            <td>${{ $invoice['total_amount'] }}</td>
        </tr>
    </table>
</body>
</html>
