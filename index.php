<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Distribuovaná databáza</title>
  <style>
      @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&family=Roboto:wght@400;500&display=swap');
 
      body {
          font-family: 'Poppins', Arial, sans-serif;
          margin: 0;
          padding: 0;
          background-color: #e6f0ff; /* Light blue */
          color: #333333; /* Dark gray */
      }
 
      table {
          width: 100%;
          max-width: 900px;
          margin: 20px auto;
          border-collapse: collapse;
          background-color: #ffffff; /* White */
          border: 1px solid #333333; /* Dark gray */
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
          border-radius: 15px; /* Rounded corners on the outer frame */
          overflow: hidden; /* Ensures corners apply to children */
      }
 
      th, td {
          border: 1px solid #333333; /* Dark gray */
          padding: 10px;
          text-align: left;
          font-family: 'Roboto', Arial, sans-serif;
      }
 
      th {
          background-color: #b3cde8; /* Medium blue */
          font-weight: bold;
      }
 
      h1 {
          font-size: 24px;
          margin: 0;
          color: #ffffff; /* White */
          font-family: 'Poppins', Arial, sans-serif;
      }
 
      .header-left {
          background-color: #5a9bd3; /* Medium blue */
          text-align: center;
          color: #ffffff; /* White */
      }
 
      .header-right {
          background-color: #82b4e3; /* Lighter blue */
          padding-left: 15px;
      }
 
      .menu {
          background-color: #b3a7d9; /* Light purple */
          text-align: center;
          vertical-align: top;
      }
 
      .menu a {
          display: block;
          padding: 10px;
          text-decoration: none;
          color: #ffffff; /* White */
          background-color: #7f6cb3; /* Medium purple */
          margin: 5px 0;
          border-radius: 5px; /* Slightly rounded buttons */
          transition: background-color 0.3s;
      }
 
      .menu a:hover {
          background-color: #5d5196; /* Darker purple */
      }
 
      .content {
          background-color: #d9eaf7; /* Light blue */
          padding: 15px;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
          font-family: 'Roboto', Arial, sans-serif;
      }
 
      .dolezite {
          font-size: 16px;
          line-height: 1.6;
      }
  </style>
  </head>
  <body>
<table border="0" cellspacing="0" width="900" height="221">
  <tr>
    <td width="200" height="27" class="header-left">
    	<font></font>
    </td>
    <td width="700" height="27" class="header-right">
    	<h1>Distribuovaná databáza</h1>
    </td>
  </tr>
  <tr>
    <td width="200" height="27" class="menu">
   <?php 
    include ("menu.php");
    ?>
    </td>
    <td width="800" height="510" valign="top" class="content">
    <div class="dolezite">
        <?php
    $m = $_GET["menu"] ?? 3;

    switch ($m) {
        case 4:
            include ("synchro.php");
            break;
        case 2:
            include ("pridaj-tovar.php");
            break;
        case 3:
            include ("vypis-db.php");
            break;
        case 5:
            include ("form-hladaj.php");
            break;
        case 6:
            include ("hladaj.php");
            break;
        case 7:
            include ("pridaj-tovar-ok2.php");
            break;
        case 8:
            include ("vypis-tovar.php");
            break;
        case 9:
            include ("hladaj-tovar-cena.php");
            break;
        case 10:
            include ("vypis-tovar-cena.php");
            break;
        case 11:
            include ("edit-tov-ok.php");
            break;
        case 12:
            include ("edit.php");
            break;
        default:
            include ("vypis-db.php");
            break;
    }
    ?>

    </div>
    </td>
  </tr>
</table>
  </body>
</html>
