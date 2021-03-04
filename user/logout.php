<?php
session_start();
echo $_SESSION['AccountID'];
session_destroy();
echo "<script>window.location='/login'</script>";
?>