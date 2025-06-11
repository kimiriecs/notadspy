<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Email</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #cacaca;">
<table role="presentation" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td align="center" style="padding: 20px;">
            <table role="presentation" cellpadding="0" cellspacing="0" width="600" style="background: rgba(255,255,255,0.46); padding: 20px; border-radius: 10px;">
                <tr>
                    <td style="font-size: 18px; font-weight: bold;">
                        Hi, {{ $subscriber }}!
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; font-size: 16px; line-height: 1.5;">
                        In advert <a href="{{$advertUrl}}">"{{$advertTitle}}"</a> <br/>
                        price was changed from {{ $oldPrice }} to {{ $newPrice }}
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding: 10px 0;">
                        <img src="{{$advertImageUrl}}"
                             alt="Image"
                             style="max-width: 100%; height: auto; display: block; border: 0; border-radius: 12px;"
                             width="300"
                        />
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding: 10px 0;">
                        <div style="width: 300px; font-size: 20px; font-weight: bold; color: #555; text-align: left; padding: 0 20px 20px 20px;">
                            {{ $newPrice }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px 0 0 0; font-size: 14px; color: #555;">
                        Best regards!<br />
                        {{config('mail.from.name')}}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
