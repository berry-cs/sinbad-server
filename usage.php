<?php
date_default_timezone_set('America/New_York');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Sinbad: Sailing the waves of data</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <style>
      body {
        position: relative;
      }
      h1 {
        padding-top: 1em;
      }
      .starter-template {
        padding: 40px 15px;
        text-align: center;
      }    
    </style>
  </head>
  <body> <!-- data-spy="scroll" data-target=".navbar" -->

    <nav class="navbar navbar-inverse">
      <span class="navbar-brand">Engaging Data Sources for CS Education</span>
    </nav>
    
    <!-- nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><strong>Sinbad</strong></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="#home">Home</a></li>
            <li><a href="#pubs">Publications</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div><! --/.nav-collapse -->
      </div>
    </nav -->

    <div class="container">

      <div id="home" class="starter-template, text-left">
        <div id="logo" class="text-right" style="float: right; margin: 1em;">
          <img src="sinbad-logo-thumbnail.png" /><br />
          <em>Sailing the waves of data</em>
        </div>
        <h1>Sinbad<br /><small>Automated Structure Inference and Binding of Data</small></h1>
      </div>

      <h2 style="clear: both;">Sharing Usage & Diagnostics</h2>
      
      <div>
      <p>To help us improve the Sinbad library, you can let your computer send us
      information about how you use the library and how it is working. 
      </p>
      <p>This information won't be used to identify you and no personal information
      is collected. We use this information to improve the library for everyone. 
      </p>
      </div>

<h3>Turn usage & diagnostics on or off</h3>

<div>
<p>After the first few times that you use the Sinbad library, you will be presented
with a preferences window allowing you to choose whether to send usage and 
diagnostics information to the developers or not.</p>
<p>After the first time you've used Sinbad, you can change your settings
at any time by running a program that contains the following lines of
code:</p>
  
<table>
  <tr><th>Java</th>
      <th>Python</th></tr>
<tr>
  <td><div style="margin: .5em"><pre>
import core.data.*;
public class Main {   // save in a Main.java file
   public static void main(String[] args) {
      DataSource.preferences();
   }
}
</pre></div></td>
  <td><div style="margin: .5em"><pre>
from sinbad import DataSource

DataSource.preferences()
</pre></div></td>
  </tr>
</table>

<h3>What information is shared with Sinbad developers</h3>

<div>
    <p>If you turn on usage and diagnostics, your computer sends information 
    to our server about what's working and not working when you use the
    Sinbad library in your programs. In particular, your computer may send
    some or all of the following information for each data source URL 
    accessed:</p>
    <ul>
        <li>The data source URL and query parameters (excluding 'appkey',
          'token', or other recognizable personal authorization parameters)</li>
      <li>Result of load() operation - success or failure messages</li>
        <li>Date and time stamp</li>
        <li>Diagnostic information for fetch() failures</li>
        <li>Cumulative use count of the Sinbad library</li>
        <li>Programming language and operating system being used</li>
    </ul>

    <p>None of this information is used to identify you. We specifically do
     <strong>not</strong> record information like your IP address.</p>
</div>


<h3>How we use this information</h3>

<div>
    <p>We use usage and diagnostics information to improve the Sinbad library.
    For example, Sinbad developers can identify data sources that are not properly
      handled by the library, or more efficient ways to support accessing certain
      data sources.</p>
</div>

    <hr />
  
  <p>&nbsp;</p>

    </div><!-- /.container -->
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
