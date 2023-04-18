<?php
if(!isset($_SESSION)) // if session is not set
{
    session_start(); // start session
} ?>
<!-- html 5 -->
<!DOCTYPE html>
<!-- language English -->
<html lang="en">
<head>
    <!-- charset is utf-8 -->
    <meta charset="utf-8">
    <!-- title with global variable that changes the name of the tab -->
    <title id="titleTab"><?php echo $_SESSION['title']; ?></title>
    <!-- meta tag used to specify the viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- meta tag to describe the website -->
    <meta name="description" content="TextMe - Communicate more easily">
    <!-- link tag to use the favicon -->
    <link id="faviconChange" rel="icon" type="image/x-icon" href="/images/website/favicon/favicon.ico">
    <!-- link tag to add an icon for apple devices when save to home screen -->
    <link rel="apple-touch-icon" href="/images/website/favicon/favicon.ico">
    <!-- links tag to link to css file -->
    <link href="../../css/stylesheet.css" rel="stylesheet" type="text/css" />
    <link href="../../css/media-style.css" rel="stylesheet" type="text/css" />
    <!-- link tag to use bootstrap 5.1.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- script part of the bootstrap 5.1.3 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<?php
    if(isset($_SESSION['user_ID']))
    { ?>
        <script src="../../Javascript/GenerateToken.js"></script>
        <script src="../../Javascript/Notification.js"></script>
        <script type="text/javascript">
        let token = new GenerateToken();
        let notification = new Notification();
        </script>
   <?php
    }
?>
