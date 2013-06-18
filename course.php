<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Whiteboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="CSS/bootstrap.css" rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <script src="JS/bootstrap.js"></script>
    <script src="JS/api.js"></script>

    <!-- Hack to get non A links in the button for JS -->
    <style>
.dropdown-menu > li > span {
  display: block;
  padding: 3px 20px;
  clear: both;
  font-weight: normal;
  line-height: 21px;
  color: #ffffff;
  white-space: nowrap;
}

.dropdown-menu > li > span:hover,
.dropdown-menu > li > span:focus,
.dropdown-submenu:hover > span,
.dropdown-submenu:focus > span {
  color: #ffffff;
  text-decoration: none;
  background-color: #17b394;
  background-image: -moz-linear-gradient(top, #18bc9c, #15a589);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#18bc9c), to(#15a589));
  background-image: -webkit-linear-gradient(top, #18bc9c, #15a589);
  background-image: -o-linear-gradient(top, #18bc9c, #15a589);
  background-image: linear-gradient(to bottom, #18bc9c, #15a589);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff18bc9c', endColorstr='#ff15a589', GradientType=0);
}
</style>
    <link href="CSS/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
    <![endif]-->
  </head>

  <body onload="loginAuth()">

    <div class="navbar navbar-inverse">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">Whiteboard</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="index.php">Home</a></li>
              <li><a href="profile.php">Profile</a></li>
              <li><a href="Assignments">Assignments</a></li>
              <li><a href="Assignments">Tracking Sheet</a></li>
              <li><a href="Assignments">Logout</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

<div class="container">
    <div class="page-header">
		<h2 align="center"> IT Extended Diploma Level 3</h2>
    </div>
    <h2 id="remove">Please wait loading</h2>




  <?php include'footer.php'; ?>
  </body>
</html>