<?php
//note: for sendEmail Function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//! ERROR FUNCTION
function error($error)
{
    require_once 'modules/errors/' . $error . '.php';
}

//! GET LAYOUT
function layout($layoutName, $data = [])
{
    if (file_exists(_WEB_PATH_TEMPLATE . '/layout/' . $layoutName . '.php')) {
        require_once _WEB_PATH_TEMPLATE . '/layout/' . $layoutName . '.php';
    }
}

//! PHPMAILER
function sendMail($to, $subject, $content)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'hieunguyenminh3103@gmail.com';                     //SMTP username
        $mail->Password = 'kxkdfzpxywiivpau';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('hieunguyenminh3103@gmail.com', 'Nguyễn Minh Hiếu');
        $mail->addAddress($to);             //Name is Optional

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->CharSet = 'UTF-8'; //
        $mail->Subject = $subject;
        $mail->Body = $content;
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        return $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

//! Check phương thức POST
function isPost()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        return true;
    }
    return false;
}

//! Check phương thức GET
function isGet()
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        return true;
    }
    return false;
}

//! Get values from POST or GET
function getBody()
{

    $bodyArr = [];

    if (isGet()) {
        // return $_GET;
        //? xử lý trước khi return (có <script></script> các kiểu...)
        if (!empty($_GET)) {
            foreach ($_GET as $key => $value) {
                //! test http://localhost:3000/user-manage/?module=auth&action=login&id[]=1 
                $key = strip_tags($key); // remove html tag

                if (is_array($value)) {
                    //? lọc các kí tự đặc biệt và encode 
                    //? lấy cả mảng ở trên host get
                    $bodyArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                } else {
                    //? lọc các kí tự đặc biệt và encode 
                    $bodyArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        };
    };
    if (isPost()) {
        // return $_GET;
        //? xử lý trước khi return (có <script></script> các kiểu...)
        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                //! test http://localhost:3000/user-manage/?module=auth&action=login&id[]=1 
                $key = strip_tags($key); // remove html tag

                if (is_array($value)) {
                    //? lọc các kí tự đặc biệt và encode 
                    //? lấy cả mảng ở trên host get
                    $bodyArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                } else {
                    //? lọc các kí tự đặc biệt và encode 
                    $bodyArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        };
    }
    return $bodyArr;
}
// check login
function isLogin() {
    $checkLogin = false;
    if (getSession('loginToken')) {
        $tokenLogin = getSession('loginToken');
        $queryToken = firstRaw("SELECT userId FROM login_token WHERE token='$tokenLogin'"); // truy vấn dựa trên token login
        if (!empty($queryToken)) {
            $checkLogin = true;
        } else {
            deleteSession('loginToken');
        }
    }
    return $checkLogin;
}

//! check email
function isEmail($email)
{
    $checkEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
    return $checkEmail;
}

function isInt($number, $range = [])
{
    /*
        $range = ['min_range'=>1, 'max_range'=>20];
        như trên là để kiểm tra xem có thuộc khoảng từ 1 đến 20 hay không
    */
    if (!empty($range)) {
        $option = ['option' => $range];
        $checkNumber = filter_var($number, FILTER_VALIDATE_INT, $option);
    } else {
        $checkNumber = filter_var($number, FILTER_VALIDATE_INT);
    }
    return $checkNumber;
}

function isFloat($number, $range = [])
{
    /*
        $range = ['min_range'=>1, 'max_range'=>20]; 
        như trên là để kiểm tra xem có thuộc khoảng từ 1 đến 20 hay không
    */
    if (!empty($range)) {
        $option = ['option' => $range];
        $checkNumber = filter_var($number, FILTER_VALIDATE_FLOAT, $option);
    } else {
        $checkNumber = filter_var($number, FILTER_VALIDATE_FLOAT);
    }
    return $checkNumber;
}

function isPhone($phone)
{
    // kiểm tra xem số điện thoại có số 0 đầu tiên hay không
    $checkFirstZero = false;
    if ($phone[0] == 0) {
        $checkFirstZero = true;
        $phone = substr($phone, 1);
    }

    $checkLastNumber = false;
    if (isInt($phone) && strlen($phone) == 9) {
        $checkLastNumber = true;
    }
    if ($checkFirstZero && $checkLastNumber) {
        return true;
    }
    return false;
}

//? hàm tạo thông báo
function getMsg($msg, $type = 'success')
{
    if (!empty($msg)) {
        echo "<div class='alert alert-$type'>";
        echo $msg;
        echo "</div>";
    }
}

//? hàm chuyển hướng
function redirect($path='index.php')
{
    header('Location: ' . $path);
    exit();
}

//? hàm thông báo lỗi (register, login)
function form_error($fieldName, $errors, $beforeHtml = '', $afterHtml='')
{
    return (!empty($errors[$fieldName])) ? $beforeHtml . reset($errors[$fieldName]) . $afterHtml : null;
}


function show_old_data($old_data, $fieldName, $default=null)
{
    return (!empty($old_data[$fieldName])) ? $old_data[$fieldName] : $default;
}
