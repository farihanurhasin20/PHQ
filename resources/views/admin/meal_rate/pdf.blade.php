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
    
<!-- <p>{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p> -->

<h1>Meal Rate</h1>
<table>
 <tr>
    <th  >From Date </th>
    <td> {{$startDate}}</td>
<td colspan="5" align="right" style="border: none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<th>To Date </th>
<td> {{$endDate}}</td>



 </tr>
</table>
<br>
<br>
<table>
    <tr>
    <th>ID</th>
    <th>Date</th>
    <th>Booked</th>
    <th>Expense (Tk.)</th>
    <th>Meal Rate (Tk.)</th>
        
    </tr> 
 
    @foreach ($mealRates as $mealRate)
    <tr>
      
        <tr>
        <td>{{ $mealRate->id }}</td>
            @php 
            $tempUser = $booking->where('date',$mealRate->date)->count(); 
            $grandTotal = $purchase->where('date',$mealRate->date) ->where('founding_source_id', 1)->sum('amount'); 
         
            @endphp
            <td>{{ $mealRate->date }}</td>
            <td>{{ $tempUser }}</td>
            <td>{{ $grandTotal }}</td>
            <td>{{ $mealRate->rate }}</td>
          
           
            
        </tr>
       

    </tr>
    @endforeach 
    
           @php 
           $totalAmount = $purchase->whereBetween("date", [$startDate, $endDate])
                ->where('founding_source_id', 1)
                ->sum('amount');

            $userNumber = $booking->whereBetween("date", [$startDate, $endDate])->count();
            $rate = $userNumber > 0 ? $totalAmount / $userNumber : 0;
           
            @endphp
<tr>     
<td colspan="3" align="right" style="border: none;"></td>
    <td  style=" font-weight: bold;"  >Total Booked:</td>
    <td>{{ $userNumber }}</td>
</tr>
<tr>     
<td colspan="3" align="right" style="border: none;"></td>
    <td  style=" font-weight: bold;"  >Total Expense:</td>
    <td>{{ $totalAmount }} Tk.</td>
</tr>
<tr>     
<td colspan="3" align="right" style="border: none; font-weight: bold;"></td>
    <td style=" font-weight: bold;"  >Total Meal Rate:</td>
    <td>{{ $rate }} Tk.</td>
</tr>
</table>
<br>
<br>


</body>
</html>