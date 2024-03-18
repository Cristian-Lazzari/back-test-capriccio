<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Conferma Email</title>
    <style>
        *{
            margin: 0;
            padding: 5px;
            box-sizing: border-box;
        }
        .mes{
            font-style: italic;
            padding: 15px 0;
        }
        hr{
            padding: 1px !important;
        }

        img{
            width: 120px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

    <img src="https://db.dashboardristorante.it/public/images/res.png" alt="simbolo ordine">
    <h1>IL Sigr/ra {{ $newOrder['name'] }} ha prenotato un tavolo!</h1>
    <p>Data prenotata: {{ $newOrder['date_slot'] }}</p>
    <span>Numero ospiti:</span>
    <span style="font-size: 35px; font-weight:bolder">{{$newOrder['n_person']}}</span>
    @if ($newOrder['message'])
        
    <hr>
    <h4>Il suo messaggio:</h4>
    <p class="mes"> {{$newOrder['message']}}</p>
    @endif    
    <hr>
    
    <p>Contatta {{$newOrder['name']}}</p>
    <a href="tel:{{$newOrder['phone']}}" class="btn btn-danger">Chiama {{$newOrder['name']}}</a>
</body>
</html>