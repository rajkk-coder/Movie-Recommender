<?php
$posterpath = array();
$movie_list = [];
$movie_idlist = [];
$paths=[];
function fetch_movie_index($name){
    if (($handle = fopen('movies_data.csv', "r")) !== FALSE) {
        $count = 0;
        while (($data= fgetcsv($handle)) !== FALSE) {
            if($name == $data[1]){
                unset($handle);
                unset($data);
                return $count;
            }
            $count+=1;
            
         }
    }else{
        echo "Something went wrong!!";
    }
    return -1;
}
function fetch_top_five($name){
    $arr = [];
    $movie_index = fetch_movie_index($name);
    if (($handle = fopen('amazing.csv', "r")) !== FALSE) {
        $count = 0;
        while (($arr= fgetcsv($handle)) !== FALSE) {
            if($count == $movie_index){
                // echo "Got it at :";
                // echo $count;
                break;
            }
            $count+=1;
            
         }
    }
    $new_arr = [];
    $count = 0;
    foreach($arr as $val){
        $dummy = array($val,$count++);
        array_push($new_arr,$dummy);
    }
    unset($arr);
    rsort($new_arr);
    $result=[];
    for($si=0; $si<6; $si++){
        array_push($result,$new_arr[$si][1]);
    }
    unset($handle);
    // echo $movie_index;
    return $result;
}
function fetch_moviename($movie_indexlist){
    $res=[];
    if (($handle = fopen('movies_data.csv', "r")) !== FALSE) {
        $count = 0;
        $id = 0;
        while (($data= fgetcsv($handle)) !== FALSE && $id<6) {
            if($count == $movie_indexlist[$id]){
                array_push($res,$data[1]);
                $id+=1;
            }
            $count+=1;
            
         }
    }else{
        echo "Something went wrong!!";
    }
    // $movie_list = $res;
    return $res;

}
function fetch_URL($movie_name){
    // fetch_top_five($movie_name);
    $first = "https://api.themoviedb.org/3/movie/";
    $last = "?api_key=8265bd1679663a7ea12ac168da84d2e8&language=en-US";
    if (($handle = fopen('movies_data.csv', "r")) !== FALSE) {
        while (($data= fgetcsv($handle)) !== FALSE) {
         if($movie_name == $data[1]){
            return $first."".$data[0]."".$last;
         }
         }
    }else{
        echo "Something went wrong!!";
    }
}
function fetch_path($url){
    $base = "https://image.tmdb.org/t/p/w500";
    $ca = curl_init();
    curl_setopt($ca, CURLOPT_URL, $url);
    curl_setopt($ca, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ca, CURLOPT_HEADER, FALSE);
    curl_setopt($ca, CURLOPT_HTTPHEADER, array("Accept: application/json"));
    $response = curl_exec($ca);
    curl_close($ca);
    $config = json_decode($response, true);
    $base= $base."".$config['poster_path'];
    return $base;
}
function recommend(){
    $movie_name = $_GET['myCountry'];
    $movie_indexlist = fetch_top_five($movie_name);
    sort($movie_indexlist);
    $GLOBALS['movie_list'] = fetch_moviename($movie_indexlist);
    $count = 0;
    foreach($GLOBALS['movie_list'] as $val){
        $loc = fetch_URL($val);
        $posterpath[$count++]=$loc;
    }
    $count = 0;
    foreach($posterpath as $val){
        $temp = fetch_path($val);
        // $count+=1;
        array_push($GLOBALS['paths'],$temp);
    }
}
recommend();
// foreach($movie_list as $val){
//     echo $val;
//     echo "\n";
// }
?>

<html>
    <head>
    <title>Movie Recommendation</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <link rel="stylesheet" href="style_output.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
  </script>
  </head>
<body>

<div class="col-md-6" style="margin:0 auto; float:none;">
    <div class="text-center">
        <h2>Top 5 Recommendation</h2>
    </div>
    
    <div class="text-center">
        <?php echo "<img class='img-thumbnail' src='$paths[0]' alt='Trulli' style='height: 183px; width: 120px;'>";?>
        <h4 align="center"><?php echo $_GET['myCountry']?></h4>
    </div>
    <br/>
    <br/>
    <br/>
   
    <table>
      <thead>
        <tr>
    <?php
        for($val=1; $val<6;$val++){
            echo "<th>\n";
            echo "<img class='img-thumbnail' src='$paths[$val]' alt='Trulli' style='height: 183px; width: 120px;'>";
            echo "<h5 class='font-weight-bold'> $movie_list[$val]</h5>";
            echo "</th>\n";
        }
    ?>
    </tr>
    </thead>
    </table>
    </div>
</body>
</html>