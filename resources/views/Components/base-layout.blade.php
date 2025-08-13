<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Project TA</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Poppins:wght@300;500;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .font-wedding {
            font-family: 'Great Vibes', cursive;
        }
    </style>

    @vite('resources/css/app.css')
</head>

<body class="">
    {{ $slot }}
</body>

</html>
