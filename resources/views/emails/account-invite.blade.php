<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Приглашение в наш сервис</title>
    <style>
        .button {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
<table cellpadding="0" cellspacing="0" border="0" align="center" width="600"
       style="background-color: #fff; border-radius: 5px;">
    <tr>
        <td align="center" style="padding: 20px;">
            <img src="{{asset('invite.svg')}}" alt="" width="150">
            <h2 style="text-align: center; margin-top: 20px;">Вас пригласили в наш сервис!</h2>
            <p style="text-align: center;">Вы получили это письмо, потому что
                <strong>{{ $inviteDto->getUserName() }}</strong> пригласил вас присоединиться к
                <strong>{{ $inviteDto->getCompanyName() }}</strong>.</p>
            <a href="{{ config('app.url')."/account/company/".$inviteDto->getCompanyId()->toString()."/profiles/accept/".$inviteDto->getCode() }}"
               target="_blank" class="button">Присоединиться сейчас</a>
            <p style="text-align: center;">Мы рады приветствовать вас и уверены, что вам понравится наш сервис.</p>
            <p style="text-align: center;">Если у вас возникнут вопросы, не стесняйтесь обращаться к нам.</p>
            <p style="text-align: center;">С уважением, Команда вашего сервиса</p>
        </td>
    </tr>
</table>
</body>
</html>
