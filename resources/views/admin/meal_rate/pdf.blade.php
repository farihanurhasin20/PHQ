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
    <th>id</th>

        <th>date</th>
        <th>rate</th>
        
    </tr> 
 
    @foreach ($mealRates as $mealRate)
    <tr>
      
        <tr>
        <td>{{ $mealRate->id }}</td>

            <td>{{ $mealRate->date }}</td>
            <td>{{ $mealRate->rate }}</td>
           
            
        </tr>
    </tr>
    @endforeach 
</table>
<br>
<br>

</body>
</html>