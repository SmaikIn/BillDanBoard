<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Уведомление о регистрации новой компании</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
<table cellpadding="0" cellspacing="0" border="0" align="center" width="600"
       style="background-color: #fff; border-radius: 5px;">
    <tr>
        <td align="center" style="padding: 20px;">
            <img src="{{asset('avatar.svg')}}" alt="" width="150">
            <h2 style="text-align: center; margin-top: 20px;">
                Уважаемый {{$user->getFirstName() . $user->getSecondName()}} приветствует вас!</h2>
            <p style="text-align: center;">Мы рады сообщить, что компания {{$company->getName()}} успешно
                зарегистрирована у нас.</p>
            <p style="text-align: center;">Мы всегда готовы помочь вам в использовании наших услуг.</p>
            <p style="text-align: center;">С уважением, Команда нашего сервиса</p>
        </td>
    </tr>
</table>
</body>
</html>
