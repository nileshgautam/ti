<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<!doctype html>
<html>
 <head>
   <title>404 Page Not Found</title>
   <style>
   body{
     width: 99%;
     height: 100%;
     background-color:#1f98cd;
     color: white;
     font-family: sans-serif;
   }
   div {
     position: absolute;
     width: 400px;
     height: 300px;
     z-index: 15;
     top: 45%;
     left: 50%;
     margin: -100px 0 0 -200px;
     text-align: center;
   }
   h1,h2{
     text-align: center;
   }
   h1{
     font-size: 60px;
     margin-bottom: 10px;
     border-bottom: 1px solid white;
     padding-bottom: 10px;
   }
   h2{
     margin-bottom: 40px;
   }
   .go-back{
     margin-top:10px;
     text-decoration: none;
     padding: 10px 25px;
     background-color: #fff;
     color: black;
     margin-top: 20px;
   }
   </style>
 </head>
 <body>
   <div>
     <h1>404</h1>
	 <h2>Page not found</h2>
	 <a href="javascript:window.history.back();" class="go-back">Go Back</a>
     <!-- <a href='' ></a> -->
   </div>
<script></script> 
</body>

</html>