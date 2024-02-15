<!DOCTYPE html>
<html>

<head>
<style>
        body {
            font-family: Arial, sans-serif;
            margin-top: -50px;
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
        }
        th {
            background-color: #ccc;
        }
    </style>
</head>

<body>
    <p>{{ $date }}</p>

    <h1>CheckIn History</h1>
    <br>

    <table>
        @php
        $totalBreakfastCount = $bookings->where('breakfast', 2)->count();
        $totalLunchCount = $bookings->where('lunch', 2)->count();
        $totalDinnerCount = $bookings->where('dinner', 2)->count();
        @endphp
        <tr>
            <th>BreakFast: </th>
            <td> {{ $totalBreakfastCount }}</td>

            <td colspan="2" align="right" style="border: none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

            <th>Lunch: </th>
            <td> {{ $totalLunchCount }}</td>

            <td colspan="2" align="right" style="border: none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

            <th>Dinner: </th>
            <td> {{ $totalDinnerCount }}</td>
        </tr>
    </table>
    <br>


    <table>
    <tr>
        <th>Reg No.</th>
        <th>Bp number</th>
        <th>Name</th>
        <th>Breakfast</th>
        <th>Lunch</th>
        <th>Dinner</th>
    </tr>

    @foreach ($users as $user)
    <tr>
        <td style="padding: 1px; font-size: small; text-align: center;">{{ $user->id }}</td>
        <td style="padding: 1px; font-size: small; padding: left 20px;">{{ $user->bp_num }}</td>
        <td style="padding: 1px; font-size: small; padding: left 20px;">{{ $user->name }}</td>
        @php
        $userBooking = $bookings->where('user_id', $user->id)->first();
        @endphp
        <td style="padding: 1px; font-size: small; text-align: center;">
            @if ($userBooking && $userBooking->breakfast == 2)
            <p>Yes</p>
            @else
            <p>No</p>
            @endif
        </td>

        <td style="padding: 1px; font-size: small; text-align: center;">
            @if ($userBooking && $userBooking->lunch == 2)
            <p>Yes</p>
            @else
            <p>No</p>
            @endif
        </td>

        <td style="padding: 1px; font-size: small; text-align: center;">
            @if ($userBooking && $userBooking->dinner == 2)
            <p>Yes</p>
            @else
            <p>No</p>
            @endif
        </td>
    </tr>
    @endforeach
</table>


</body>

</html>
