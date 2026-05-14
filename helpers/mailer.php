  <?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require_once __DIR__ . '/../../vendor/autoload.php';

  function send_mail(
      string $toEmail,
      string $toName,
      string $subject,
      string $htmlBody,
      string $plainText = ''
  ): array {
      $mail = new PHPMailer(true);

      try {
          $mail->isSMTP();
          $mail->Host       = 'smtp.gmail.com';
          $mail->SMTPAuth   = true;
          $mail->Username   = 'your_gmail@gmail.com';   
          $mail->Password   = 'xxxx xxxx xxxx xxxx';    
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
          $mail->Port       = 587;

          
          $mail->setFrom('your_gmail@gmail.com', 'Happy Care Clinic');
          $mail->addAddress($toEmail, $toName);
          $mail->addReplyTo('your_gmail@gmail.com', 'Happy Care Clinic');

          
          $mail->isHTML(true);
          $mail->CharSet = 'UTF-8';
          $mail->Subject = $subject;
          $mail->Body    = $htmlBody;
          $mail->AltBody = $plainText ?: strip_tags($htmlBody);

          $mail->send();
          return ['ok' => true, 'error' => ''];
      } catch (Exception $e) {
          return ['ok' => false, 'error' => $mail->ErrorInfo];
      }
  }




  function email_template(string $content): string
  {
      $year = date('Y');
      return <<<HTML
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  </head>
  <body style="margin:0;padding:0;background:#f4f4f8;font-family:'Segoe UI',Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f8;padding:32px 0;">
      <tr><td align="center">
        <table width="560" cellpadding="0" cellspacing="0"
              style="background:#fff;border-radius:20px;overflow:hidden;
                      box-shadow:0 8px 32px rgba(255,39,104,.10);">
          <tr>
            <td style="background:linear-gradient(135deg,#ff2768 0%,#ff6fa3 100%);
                      padding:28px 40px;text-align:center;">
              <h1 style="margin:0;color:#fff;font-size:1.45rem;font-weight:700;
                        letter-spacing:.04em;">💊 Happy Care Clinic</h1>
              <p  style="margin:4px 0 0;color:rgba(255,255,255,.82);
                        font-size:.7rem;letter-spacing:.2em;">TRUSTED MEDICAL CARE</p>
            </td>
          </tr>
          <tr>
            <td style="padding:36px 40px 28px;">$content</td>
          </tr>
          <tr>
            <td style="background:#fdf0f4;padding:18px 40px;text-align:center;
                      border-top:1px solid #fce0e8;">
              <p style="margin:0;font-size:.73rem;color:#aaa;line-height:1.6;">
                © $year Happy Care Clinic. All rights reserved.<br>
                If you did not request this email, please ignore it.
              </p>
            </td>
          </tr>
        </table>
      </td></tr>
    </table>
  </body>
  </html>
  HTML;
  }