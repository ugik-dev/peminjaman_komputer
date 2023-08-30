<!DOCTYPE>
<html xmlns='http://www.w3.org/1999/xhtml'>

<head>
    <meta name='viewport' content='width=device-width' />
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <title>Actionable emails e.g. reset password</title>
</head>

<body style='-webkit-font-smoothing: antialiased;
	-webkit-text-size-adjust: none;
	width: 100% !important;
	height: 100%;
	line-height: 1.6;background-color: #f6f6f6;
    font-family: "Helvetica Neue", Helvetica, Helvetica, Arial, sans-serif;'>
    <table class='body-wrap' style='background-color: #f6f6f6;	width: 100%;'>
        <tr>
            <td></td>
            <td class='container' width='600' style='display: block !important;
                          max-width: 600px !important;
                          margin: 0 auto !important;
                          clear: both !important;'>
                <div class='content' style='max-width: 600px;
	margin: 0 auto;
	display: block;
	padding: 20px;'>
                    <table class='main' width='100%' cellpadding='0' cellspacing='0' style='	background: #fff;
	border: 1px solid #e9e9e9;
	border-radius: 3px;'>
                        <tr>
                            <td class='content-wrap' style='padding: 20px;'>
                                <table cellpadding='0' cellspacing='0'>
                                    <tr>
                                        <td class='alert alert-good' style='background: #1ab394;font-size: 16px;	color: #fff;	font-weight: 500;
	padding: 20px;
	text-align: center;
	border-radius: 3px 3px 0 0;'>
                                            Activation Your Courses </td>
                                    </tr>
                                    <tr>
                                        <td class='content-block' style='padding: 0 0 20px;'>
                                            <br>
                                            <h4>Welcome in YOUR COURSES</h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='content-block' style='padding: 0 0 20px;'>
                                            Email anda telah berhasil didaftarkan.
                                            <br><br> Username : {$data['username']}
                                            <br> Password : {$data['password_hash']}
                                            <br> Activator : {$data['activator']}
                                            <br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='content-block' style='padding: 0 0 20px;'>
                                            Untuk login harap melakukan aktivasi email terlebih dahulu dengan klik tombol aktifasi dibawah. </td>
                                    </tr>
                                    <tr>
                                        <td class='content-block aligncenter' style='padding: 0 0 20px; text-align: center;'>
                                            <a href='{$url_act}' target='_blank' class='btn-primary' style="text-decoration: none;
	color: #fff;
	background-color: #1ab394;
	border: solid #1ab394;
	border-width: 5px 10px;
	line-height: 2;
	font-weight: bold;
	text-align: center;
	cursor: pointer;
	display: inline-block;
	border-radius: 5px;
	text-transform: capitalize;">Confirm email address</a>
                                            <br> atau masuk kealamat {$url_act}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <div class='footer' style='width: 100%;	clear: both;	color: #999;	padding: 20px;'>
                        <table width='100%'>
                            <tr style='text-align: center;'>
                                <td class='aligncenter content-block' style='padding: 0 0 20px;'>Follow <a style='color: #999;' href='https://instagram.com/ugikdev'>@ugikdev</a> on Instagram.</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
            <td></td>
        </tr>
    </table>

</body>

</html>