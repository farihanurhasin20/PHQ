<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            font-size: 24px;
            text-align: center;
        }
        h3 {
            font-size: 22px;
            text-align: center;
        }
        h4 {
            font-size: 18px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        p.color-text, p.size-text {
            font-size: small;
            color: #212529;
            margin: 0 0;
            padding-bottom: 2px;
        }
        th {
            background-color: #ccc;
        }
    </style>


  
</head>
<body>
    
<p>{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>

<h1>Today's CheckIn History</h1>
<table>
    <tr>
        <th>Roll</th>
        <th>Bp_num</th>
        <th>Name</th>
        <th>Breakfast</th>
        <th>Lunch</th>
        <th>Dinner</th>
    </tr> 
    @php
    $totalBreakfastCount = 0;
    $totalLunchCount = 0;
    $totalDinnerCount = 0;
    @endphp
    
    @foreach ($users as $user)
    <tr>
      
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->bp_num }}</td>
            <td>{{ $user->name }}</td>
            @php
            $userBooking = $bookings->where('user_id', $user->id)->first();
            @endphp
            <td>
                @if ($userBooking && $userBooking->breakfast == 2)
                <p class="text-success">Yes</p>
                @php
                $totalBreakfastCount++;
                @endphp
                @else
                <p class="text-danger">No</p>
                @endif
            </td>

            <td>
                @if ($userBooking && $userBooking->lunch == 2)
                <p class="text-success">Yes</p>
                @php
                $totalLunchCount++;
                @endphp
                @else
                <p class="text-danger">No</p>
                @endif
            </td>

            <td>
                @if ($userBooking && $userBooking->dinner == 2)
                <p class="text-success">Yes</p>
                @php
                $totalDinnerCount++;
                @endphp
                @else
                <p class="text-danger">No</p>
                @endif
            </td>
            
        </tr>
    </tr>
    @endforeach 
</table>
<br>
<br>
<p>Total People with BreakFast: {{ $totalBreakfastCount }}</p>
<p>Total People with Lunch: {{ $totalLunchCount }}</p>
<p>Total People with Dinner: {{ $totalDinnerCount }}</p>
</body>
</html>