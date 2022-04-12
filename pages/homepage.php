<?php 
include("header.php");
?>
</head>

<?php
session_start();
echo($_SESSION['mail']);
if($_SESSION['mail']==null){
    echo "<script>noSession();</script>";
    session_abort();
    header("refresh:0;url=../index.php");
}

if($_)
?>

<body>
    
</body>
</html>