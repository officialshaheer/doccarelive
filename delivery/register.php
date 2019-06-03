<!DOCTYPE html>

<html lang="en">

    <head>

        <meta charset="UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="theme-color" content="#881c58">

        <link rel="icon" href="img/footer/fav_icon1.png" type="image/jpg" sizes="16x16">
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style type="text/css">
        
    body {
      background-color: #466020;
      color: white;
      margin: 0;
      }
      .container {
      position: fixed;
      background-color:#881058;
      border-radius: 12px;
      height: 100%;
      width:100%;
      color: white;
      top: 0%;
    }  
    .header {
      position: relative;
      background-color:#881058;
      border-radius: 12px;
      height: auto;
      width:50%;
      color: white;
      top: 0%;
      left: 25%;
    }  
    .sub {
      background-color: #FCFEFB;
      border-radius: 12px;
      height: 100%;
      width:100%;
      color: #333;
      position: absolute;
    }
   .sub-availableworkers {
      background-color: #333;
      height: 100%;
      width:15%;
      color: #466020;
      position: relative;
   }
   .sub-workerlogin {
      background-color: #CEEBC2;
      height: 100%;
      width:50%;
      left: 25%;
      color: #466020;
      position: fixed;
      top: 20%;
   }
   input[type=button], input[type=submit], input[type=reset] {
  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 16px 32px;
  text-decoration: none;
  cursor: pointer;
}

       </style>    
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    </head>
           
<body>
  <div class="container">

  <div class="header">
  <center><h1>Delivery System - Doc-Care Live</h1></center>
  </div>

  <div class="sub">
  <center><h2>Register as Worker</h2></center>  

  <div class="sub-availableworkers">
   <center>
  <input type="button"  name="delBtn" value="View Available Workers"></center> 

  </div>

  <div class="sub-workerlogin">
  	<br>
   <center>
 	
 	<form>
 		<label>Username :</label><input type="text" id="w_username" name=""></br>
 		<label>Password :</label><input type="text" id="w_password" name=""></br>
 		<label>Email :</label><input type="email" id="w_email" name=""></br>
 		<input type="button" id="workerRegBtn" name="" value="Register"></br>
 	</form>

<script type="text/javascript">
    $(function(){

     $('#workerRegBtn').click(function(event){

                var w_username = $('#w_username').val();
                var w_password = $('#w_password').val();     
               	var w_email = $('#w_email').val();

                $.ajax({
                    url: 'registerWorker.php',
                    type: 'POST',
                    data: {
                        w_username: w_username,
                        w_password: w_password,
                        w_email: w_email
                      },
                success: function(data){                       
                      // var data = JSON.parse(data);
                      console.log(data);
                      alert("Registered!");
                      // if(data.success){
                      //   alert("Worker Registered!");
                      //   window.location.replace("work.php");
                      //   }
                      //   else {
                      //   alert(data.message); 

                      //   // window.location.replace("nodelogin.php");  
                      //   }                                   
                    }
                });
      });


});
</script>


  </center> 

  </div>


</div>

</body>   
</html>

