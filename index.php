<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style_input.css">
  <script src="autocomplete.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
  </script>
</head>
<body>
<div class="col-md-6" style="margin:0 auto; float:none;">
    <div class="text-center">
      <br/>
      <br/><br/><br/><br/><br/><br/><br/>
      <h2>Movie Name</h2>
      <br/>
    </div>
    <div class="text-center">
    <form autocomplete="off" action="action_page.php">
        <div class="autocomplete" style="width:300px;">
          <input id="myInput" type="text" name="myCountry" placeholder="Type movie name">
        </div>
        <input id = "raju" type="submit">
    </form>
    </div>
</div>
</body>
<script>
autocomplete(document.getElementById("myInput"), countries);
</script>
</html>