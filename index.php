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
        <p class="lead" style="clear: both;">Welcome! </p>
        <p>
          <code>Sinbad</code> is a code framework that facilitates the use of online data sources in programming courses. It enables novice (or advanced) programmers (i.e. students) to easily access online data sources in standard formats (XML, CSV, JSON) with minimal syntactic overhead and no worrying about low-level issues of parsing and extracting data. Given a data source URL, the library infers its structure, downloads, caches, parses, and binds the data using programming-defined data structures and representations.
        </p>
        
      </div>
      
      <div id="getit" class="page-header">
        <h2>Download &amp; Docs</h2>

        <h3>Development version</h3>
        <div style="margin-left: 2em;">
	<p><strong>(DOWNLOAD THIS)</strong></p>
	<p><strong><a href="sinbad.jar">sinbad.jar</a></strong> <small>[Last modified: <?php print date ("F d Y g:i:sa.", filemtime("sinbad.jar"))   ?>]</small> Contains the latest features and bug-fixes. See the Github repository <a href="https://github.com/berry-cs/sinbad/commits/master" target="_blank">commit history</a> for details.
	</p>

            <h4>Documentation</h4>
            <ul>
              <li><a href="https://github.com/berry-cs/sinbad/blob/master/docs/quick-java.md" target="_blank">Quick Reference</a></li>
              <li>Tutorials:
                <ul>
                  <li><a href="https://github.com/berry-cs/sinbad/blob/master/tutorials/java/welcome01.md">Introduction</a></li>
                  <li><a href="https://github.com/berry-cs/sinbad/blob/master/tutorials/java/welcome02-arr.md">Fetching Primitive Type Arrays</a></li>
                  <li><a href="https://github.com/berry-cs/sinbad/blob/master/tutorials/java/welcome02-obj.md">Fetching Objects</a></li>
                  <li>Fetching Arrays of Objects (code examples: <a href="https://github.com/berry-cs/sinbad/raw/master/tutorials/java/Welcome03.java">simple</a> and <a href="https://raw.githubusercontent.com/berry-cs/sinbad/master/tutorials/java/Welcome03Full.java">full</a>)</li>

		</ul>
	      </li>
              <li><a href="https://github.com/berry-cs/sinbad" target="_blank">Github site</a></li>
            </ul>          

	<p>Here an <a href="https://github.com/berry-cs/big-data-cse/blob/master/ideas/sources.txt" target="_blank">unorganized list of online data sources</a> to play with.
	</div>
	
	

        <h3>Version 1.0 (July 2016)</h3>
        <div style="margin-left: 2em;">
          <p>This is a reimplementation of the initial Java prototype that maintains the same overall interface and features while providing major improvements in the implementation, including better abstraction over data formats (making it easier to define "plugins" to handle new data formats).</p>
          
          <p><button  type="button" class="btn btn-info" data-toggle="collapse" data-target="#v10">Details...</button></p>
          <div id="v10" class="collapse">
            <h4>Library</h4>
            <ul>
              <li><a href="sinbad-1.0.jar">sinbad-1.0.jar</a>
                  <br /><small><a href="https://raw.githubusercontent.com/berry-cs/sinbad/master/release-notes/version-1.0.txt" target="_blank">Release notes</a></small>
              </li>
            </ul>

            <h4>Documentation</h4>
            <ul>
              <li><a href="https://github.com/berry-cs/sinbad/blob/master/docs/quick-java.md" target="_blank">Quick Reference</a></li>
              <li>Tutorials:
                <ul>
                  <li><a href="https://github.com/berry-cs/sinbad/blob/master/tutorials/java/welcome01.md">Introduction</a></li>
                  <li><a href="https://github.com/berry-cs/sinbad/blob/master/tutorials/java/welcome02-arr.md">Fetching Primitive Type Arrays</a></li>
                  <li><a href="https://github.com/berry-cs/sinbad/blob/master/tutorials/java/welcome02-obj.md">Fetching Objects</a></li>
                  <li>Fetching Arrays of Objects (code examples: <a href="https://github.com/berry-cs/sinbad/raw/master/tutorials/java/Welcome03.java">simple</a> and <a href="https://raw.githubusercontent.com/berry-cs/sinbad/master/tutorials/java/Welcome03Full.java">full</a>)</li>

		</ul>
	      </li>
              <li><a href="https://github.com/berry-cs/sinbad" target="_blank">Github site</a></li>
            </ul>          
          </div>
          
        </div> <!-- v 1.0 -->

        
        
        <h3>Version 0.5</h3>
        <div style="margin-left: 2em;">
          <p>This is the initial implementation of the framework in Java. It has been used in courses for a few years. There are some inefficiencies dealing with data, especially CSV files.</p>
          <p><button  type="button" class="btn btn-info" data-toggle="collapse" data-target="#v05">Details...</button></p>
          <div id="v05" class="collapse">
            <h4>Library</h4>
            <ul>
              <li><a href="../big-data/easydata.jar">easydata.jar</a> (this version of the library renames the <code>big.data</code> package to <code>easy.data</code> to more accurately reflect the nature of the services it provides. <br /><small>[Last modified: <?php print date ("F d Y g:i:sa.", filemtime("../big-data/easydata.jar"))   ?>]</small>
              <li><a href="../big-data/bigdata.jar">bigdata.jar</a> <br /><small>[Last modified: <?php print date ("F d Y g:i:sa.", filemtime("../big-data/bigdata.jar"))   ?>]</small>
            </ul>

            <h4>Documentation</h4>
            <ul>
              <li><a href="https://github.com/berry-cs/big-data-cse" target="_blank">Github site</a>  
              </li>
              <li>Tutorials:
                <br /><small>(Replace package references to <code>big.data</code> with <code>easy.data</code> if using the <code>easydata.jar</code> file.)</small>
                <ul>
                  <li><a href="https://github.com/berry-cs/big-data-cse/blob/master/tutorials/welcome01.md">Introduction</a></li>
                  <li><a href="https://github.com/berry-cs/big-data-cse/blob/master/tutorials/welcome02-arr.md">Fetching Primitive Type Arrays</a></li>
                  <li><a href="https://github.com/berry-cs/big-data-cse/blob/master/tutorials/welcome02-obj.md">Fetching Objects</a></li>
                  <li>Fetching Arrays of Objects (code examples)</li>
                </ul>
              </li>
              <li><a href="https://github.com/berry-cs/big-data-cse/tree/master/tutorials">Tutorial code examples</a></li>
            </ul>
        </div>
        </div> <!-- version 0.5 -->
          
      </div>
      
      <div id="pubs" class="page-header">
        <h2>Publications and Presentations</h2>
        
        <ul>
          <li><a href="https://doi.org/10.1145/2899415.2899437" target="_blank">ITiCSE '16 paper</a>: "A Generic Framework for Engaging Online Data Sources in
Introductory Programming Courses" [<a href="iticse16-paper.pdf">local copy</a>] [<a href="iticse16-slides.pdf">slides</a>]</li>
	     <li><a href="http://2015.splashcon.org/track/splash2015-splash-e#event-overview" target="_blank">SPLASH-E '15</a> workshop presentation: "A Generic Framework for Engaging Online Data Sources in Introductory Programming Courses"
          <li><a href="https://dl.acm.org/citation.cfm?id=2544280&CFID=633189652&CFTOKEN=58804699
" target="_blank">SIGCSE '14</a> poster: "Towards engaging big data for CS1/2" [<a href="bigdata-poster.pdf">local copy</a>]</li>
        </ul>
        
      </div>
      
      <div id="contact" class="page-header">
        <h2>Contact</h2>
        <p>Bug reports, suggestions for improvement, code contributions, or requests for help using the library are very welcome.</p>
        <p><a href="http://cs.berry.edu/~nhamid">Nadeem Abdul Hamid</a>, 
          <a href="mailto:nadeem@acm.org">nadeem@acm.org</a>
        </p>
      </div>

    </div><!-- /.container -->
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
