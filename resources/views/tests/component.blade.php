<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css','resources/js/app.js',])
    <title>Document</title>
</head>
<body>
    test
    <x-tests.card class="bg-red-500"/>
    <x-tests.card/>
    <x-tests.button />
    <x-tests.button class="bg-red-500"/>
</body>
</html>