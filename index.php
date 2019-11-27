<?php
$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$parsedUrl = parse_url($url);

$host = explode('.', $parsedUrl['host']);

$subdomain = $host[0];
if ($subdomain != "htmlshare" && $subdomain != "www"){

$servername = "localhost";
$username = "<db_user>";
$password = "<db_pass>";
$dbname = "htmlshare";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM html_codes where shared_url='$subdomain'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
$row = $result->fetch_assoc();

echo $row["html_data"];
}else{
  echo "<pre>Not found</pre>";
  http_response_code(404);
}
$conn->close();

}else{
  echo '<html>
   <head>
      <title>HTML Share - Share HTML</title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta name="description" content="Host HTML and share it with others. No login required.">
      <link type="text/css" href="style.css?v=0.0011" rel="stylesheet" media="screen, projection">
      <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <script src=\'https://www.google.com/recaptcha/api.js\'></script>
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
      <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable = yes">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
      <script src="https://malsup.github.io/jquery.form.js"></script> 
      <link rel="icon" type="image/png" href="favicon.jpg" sizes="192x192">
      <script src="codemirror/lib/codemirror.js"></script>
      <link rel="stylesheet" href="codemirror/lib/codemirror.css?v=0.02">
      <script src="codemirror/mode/javascript/javascript.js?"></script>
      <script src="codemirror/mode/xml/xml.js"></script>
      <script src="codemirror/mode/javascript/javascript.js"></script>
      <script src="codemirror/mode/css/css.js"></script>
      <script src="codemirror/mode/htmlmixed/htmlmixed.js"></script>
      <script src="codemirror/addon/edit/matchbrackets.js"></script>
      <!-- Global site tag (gtag.js) - Google Analytics -->
      <script async src="https://www.googletagmanager.com/gtag/js?id=UA-142140902-1"></script>
      <script>
         window.dataLayer = window.dataLayer || [];
         function gtag(){dataLayer.push(arguments);}
         gtag(\'js\', new Date());
         
         gtag(\'config\', \'UA-142140902-1\');
      </script>
      <style type="text/css">
         .swal-content #google-ver{
         padding: 0% 50% 0 11.5% !important;
         overflow:hidden;
         }
         #myHistoryTablet{
         margin-left: auto;
         margin-right: auto;
         }
         .button22 {
         background-color: #2ECC71; /* Green */
         border: none;
         color: white;
         padding: 15px 32px;
         text-align: center;
         text-decoration: none;
         display: inline-block;
         font-size: 16px;
         margin: 4px 2px;
         cursor: pointer;
         -webkit-transition-duration: 0.4s; /* Safari */
         transition-duration: 0.4s;
         border-radius: 24px;
         }
      </style>
   </head>
   <body class="body">
      <div id="myHistoryTable" style="display:none;"></div>
      <div class="layout">
         <div class="button">
            <button type="button" class="button__trigger">START</button>
            <div class="toolbar">
               <div id="google-ver" style="display: none;" data-callback="imNotARobot" class="g-recaptcha" data-sitekey="6Ldp4KYUAAAAAGgAdCb_WzoQ-F-ge_llTBs1SSyz"></div>
               <ul class="toolbar__slot toolbar__slot--left">
                  <li class="toolbar__item" id="history_label"><a href="#" style="color:white;" type="button" onclick=\'goHistory();\'><i class="material-icons">history</i> HISTORY</a></li>
               </ul>
               <!--  <ul class="toolbar__slot toolbar__slot--right">
                  <li class="toolbar__item"><div class="g-recaptcha" data-sitekey="<google_site_key>"></div></li>
                  </ul>-->
            </div>
            <form action="post.php" method="post" id="confirmationForm">
               <div class="editor">
                  <textarea class="editor__textarea" placeholder="html code..." form="confirmationForm" name="html_data" style="height: 80% !important;" id="textarea"></textarea>
                  <button type="button" style="float: right;margin-right: 12px;position: relative;margin-top: -10%;z-index:2;" onclick=\'go()\' class="button22 button1">GO</button>
            </form>
            <p style="background-color: #FFC300; border-radius: 5px;margin: 2px; display:inline;line-height:24px;
               padding:4px; z-index: 20">Developed by <a href="https://nullx.me" target="_blank">nullx</a></p>
            </div>
         </div>
      </div>
      <script type="text/javascript" src="script.js"></script>
   </body>
</html>';
}
if (isset($_GET["final_url"])){
  echo '<script>swal("YEEEYY","Your HTML has been uploaded. You can access it here:", "success",{
    content: {
        element: "a",
        attributes: {
            href: "https://'.$_GET["final_url"].'.htmlshare.cloud",
            target: "_blank",
            innerText: "https://'.$_GET["final_url"].'.htmlshare.cloud"},buttons: {

  }}})
  .then((value) => {
  switch (value) {

 
    default:
      window.location = window.location.href.split(\'?\')[0];
  }
});
  </script>';
}else if(isset($_GET["error"])){
    echo '<script>swal("ERROR","'.$_GET["error"].'", "error",{

    })
.then((value) => {
  switch (value) {

 
    default:
      window.location = window.location.href.split(\'?\')[0];
  }
});
  </script>';
}
?>

