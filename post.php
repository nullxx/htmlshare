 <?php
if (!isset($_COOKIE["captcha_token"])) {
    echo "Cookie named '" . $cookie_name . "' is not set!";
    header("Location: /?error=You don't have permission to do that.");
    
} else {
    
    setcookie("captcha_token", "", time() - 3600);
    
    
    $servername = "localhost";
    $username = "<db_user>";
    $password = "<db_pass>";
    $dbname = "htmlshare";
    
    $htmlData = $_POST["html_data"];

    if (strlen($htmlData) > 1024 * 1024 * 1) {
        header("Location: /?error=Your HTML code is too large. Max 1MB");
        exit();
    } else {
        $userIp = $_POST["user_ip"];
        // Create connection
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $realIP = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $realIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $realIP = $_SERVER['REMOTE_ADDR'];
        }
        $url  = generateRandomString();
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $htmlData = $conn->real_escape_string($htmlData);
        $sql      = "INSERT INTO html_codes (html_data, user_ip, shared_url)
VALUES ('" . $htmlData . "', '$realIP', '$url')";
        
        if ($conn->query($sql) === TRUE) {

            $date = date("D M j G:i:s T Y");
            
            
            echo '<script>
          if (typeof(Storage) !== "undefined") {
            localStorage.setItem("' . $url . '", "' . $date . '");
          } else {
            console.log("Sorry, your browser does not support Web Storage...");
          }
        </script>';
            
            header("Refresh:0.1; url=/?final_url=$url", true, 303);
            
        } else {
            header("Location: /?error=An error occurred.");
        }
        
        $conn->close();
    }
    
}
function generateRandomString($length = 10) {
    $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>
