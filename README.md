# line_notify_conf
ให้สมัคร User ID: และ API Key: มาใส่ในไฟล์ linenotify_conf.php ก่อนนะครับที่
https://htmlcsstoimage.com/dashboard
แล้วเอาค่าที่ได้จากการสมัครใส่ที่ curl_setopt($ch, CURLOPT_USERPWD, "User ID" . ":" . "API Key"); แทน User ID และ API Key


จากนั้นให้สร้าง line token เพื่อส่งเข้าไปในกลุ่มโดย สมัคร line notify token ที่ 
https://notify-bot.line.me/th/
แล้วเอามาใส่ในไฟล์ linenotify_conf.php ตรงที่ Authorization: Bearer xxxx  แทนคำว่า xxxx

Cr.อ อ๊อฟ Jattupron Butsart สสจ.l01
