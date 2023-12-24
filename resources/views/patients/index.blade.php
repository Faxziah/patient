<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Список пациентов</title>
</head>
<body>
<div class="container">

    @if(\Illuminate\Support\Facades\Session::has('success'))
        <div style="background-color: #c0f1bc; padding: 20px">
            <p style="color: #017001; padding-right: 20px">{{ Session::get('success') }}</p>
        </div>
    @endif

    <div style="margin: 30px">
        <a href="{{ route('patients.create') }}" style="font-size: 20px; color: #007196">Добавить пациента</a>
    </div>

    @if($patients->isEmpty())
        <div>Пациентов еще нет</div>
    @else
        <table>
            <thead>
            <tr>
                <th>Имя и фамилия</th>
                <th>Дата рождения</th>
                <th>Возраст</th>
            </tr>
            </thead>
            <tbody>
            @foreach($patients as $patient)
                <tr>
                    <td>{{ $patient->first_name . ' ' . $patient->last_name }}</td>
                    <td>{{ $patient->birthday_rus }}</td>
                    <td>{{ $patient->age . ' ' . $patient->age_type_rus }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

</div>
</body>
</html>