<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ordine confermato</title>
</head>
<body>
    <img src="https://db.dashboardristorante.it/public/images/or.png" alt="simbolo ordine">
    <h1>Ordine confermato</h1>
    <p>
        Gentile {{ $order['name'] }},<br>
        siamo lieti di comunicarle che il suo ordine è stato confermato<br> 
        Grazie di averci scelto
    </p>

    <p>Cordialmente,</p>
    <p>Il Capriccio di Leo</p>
</body>
</html>