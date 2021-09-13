<?php
 if($_GET['button1']){fun1();}
 if($_GET['button2']){fun2();}

 function fun1()
 {
     echo "<h2>hello world</h2>";
 }
 function fun2()
 {  
     echo "<h2>end of the world</h2>";

    
 }

?>

<html>
<head>
<style>
.button {
  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}
</style>
</head>
<body>
<br>
<button 
        id="btnfun1" 
        class="button"
        name="btnfun1" onClick='location.href="?button1=1"'
        width: 200%;
        height: 200%;
        >hello</button>
<br>
<button 
        id="btnfun2" 
        class="button"
        name="btnfun2" onClick='location.href="?button2=1"'
        width: 200%;
        height: 200%;
        >end</button>




<!-- See how this paragraph is wrapped in h2, header 2 -->
<h2>CSS Buttons</h2>

<button>Default Button</button>

<!-- This is a normal hyperlink -->
<a href="#">Link Button</a>

<button>Button</button>

<input type="button" value="Input Button">

<form action="/hello.php">
    <input type="submit" name="btn_submit" value="Reset" />
</form>
    
</body>
</html>

