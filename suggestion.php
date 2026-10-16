<!DOCTYPE html>
<html>

<head>
  <title>IKnowThisVoice</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Audiowide&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  </link>
  <script>
  </script>

</head>

<body>
  <?php
  ini_set('display_errors', 1);
  $ca_firstname = $ca_surname = $ca_nickname = $ca_gender = $series = $movie = $videogame = $va_firstname = $va_surname = $va_language = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["_ca-firstname"]) && isset($_POST["_va-firstname"]) && isset($_POST["_va-surname"])) {
      $ca_firstname = test_input($_POST["_ca-firstname"]);
      if ($_POST["_ca-surname"] == "") {
        $ca_surname = NULL;
      } else {
        $ca_surname = test_input($_POST["_ca-surname"]);
      }
      if ($_POST["_ca-nickname"] == "") {
        $ca_nickname = NULL;
      } else {
        $ca_nickname = test_input($_POST["_ca-nickname"]);
      }
      $ca_gender = test_input($_POST["_ca-gender"]);
      if ($ca_gender == "m") {
        $ca_gender = 1;
      } else if ($ca_gender == "f") {
        $ca_gender = 2;
      } else if ($ca_gender == "o") {
        $ca_gender = 3;
      }
      if ($_POST["_series"] == "") {
        $series = NULL;
      } else {
        $series = test_input($_POST["_series"]);
      }
      if ($_POST["_season"] == "") {
        $season = NULL;
      } else {
        $season = test_input($_POST["_season"]);
      }
      if ($_POST["_movie"] == "") {
        $movie = NULL;
      } else {
        $movie = test_input($_POST["_movie"]);
      }
      if ($_POST["_videogame"] == "") {
        $videogame = NULL;
      } else {
        $videogame = test_input($_POST["_videogame"]);
      }

      $va_firstname = test_input($_POST["_va-firstname"]);
      if ($_POST["_va-surname"] == "") {
        $va_surname = NULL;
      } else {
        $va_surname = test_input($_POST["_va-surname"]);
      }
      $va_gender = test_input($_POST["_va-gender"]);
      if ($va_gender == "m") {
        $va_gender = 1;
      } else if ($va_gender == "f") {
        $va_gender = 2;
      } else if ($va_gender == "o") {
        $va_gender = 3;
      }
      $va_language = test_input($_POST["_va-language"]);
    }
    $daten = "\"" . $ca_firstname . "\",\"" . $ca_surname . "\",\"" . $ca_nickname . "\",\"" . $ca_gender . "\",\"" . $series . "\",\"" . $season . "\",\"" . $movie . "\",\"" . $videogame . "\",\"" . $va_firstname . "\",\"" . $va_surname . "\",\"" . $va_gender . "\",\"" . $va_language . "\"";
    $connect_db = mysqli_connect("localhost", "root", "") or die("Keine Verbindung zum Datenbankserver");
    mysqli_select_db($connect_db, "iktv") or die("Datenbank existiert nicht");

    $query = "INSERT INTO suggestion(cFirstName, cSurname, cNickname ,cGender, cSeries, cSeason, cMovie, cVideogame, vaFirstName, vaSurname,vaGender, vaLanguage) VALUES ($daten);";

    mysqli_query($connect_db, $query) or die("Anfrage gescheitert: " . mysqli_error($connect_db));
  }

  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }



  /*
  $daten = json_encode(array(
    "ca_firstname" => $ca_firstname,
    "ca_surname" => $ca_surname,
    "ca_nickname" => $ca_nickname,
    "ca_gender" => $ca_gender,
    "series" => $series,
    "movie" => $movie,
    "videogame" => $videogame,
    "va_firstname" => $va_firstname,
    "va_surname" => $va_surname,
    "va_language" => $va_language
  ), JSON_PRETTY_PRINT);


  $filepath = "/opt/lampp/htdocs/Suggestions/";
  file_put_contents($filepath . "suggestion-" . $ca_firstname . ".json", $daten);
*/
  ?>
  <h1 id="überschrift" style="text-align: center;">I know this voice!</h1>
  <div class="form-container">
    <!-- Form of the suggestions site -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="off" id="suggestionForm">
      <!-- Input of Character Name -->
      <p>
        Please Enter the Name of the Character you want to suggest to the Site:
      </p>
      <div class="input-container">

        <input type="text" id="firstname" class="suggestionForm" autofocus required
          placeholder="Character-Firstname" name="_ca-firstname">

        <input type="text" id="surname" class="suggestionForm" autofocus
          placeholder="Character-Surname" name="_ca-surname">

        <input type="text" id="nickname" class="suggestionForm" autofocus
          placeholder="Character-Nickname" name="_ca-nickname">
      </div>
      <select name="_ca-gender" id="gender_dropdown">
        <option value="m">Male</option>
        <option value="f">Female</option>
        <option value="o">Other</option>
      </select>
      <p>
        Here you can enter the Series/Movie/VideoGame the Character is voiced in:
      </p>
      <!-- Input of Chracter Series/Movie/VideoGame -->
      <div class="input-container">
        <input type="text" id="series" class="suggestionForm" autofocus
          placeholder="Series" name="_series">
        <input type="number" id="series" class="suggestionForm" autofocus
          placeholder="Season" name="_season" value="1" min="1">

        <input type="text" id="movie" class="suggestionForm" autofocus
          placeholder="Movie" name="_movie">

        <input type="text" id="videogame" class="suggestionForm" autofocus
          placeholder="Video Game" name="_videogame">
      </div>
      <p>
        Please Enter the Name of the Voice Actor who voices the Character and their specified language:
      </p>
      <!-- Input of Voice Actor Name-->
      <div class="input-container">
        <input type="text" id="voice_actor_firstname" class="suggestionForm" autofocus required
          placeholder="Firstname of Voice Actor" name="_va-firstname">
        <input type="text" id="voice_actor_surname" class="suggestionForm" autofocus required
          placeholder="Surname of Voice Actor" name="_va-surname">
        <select name="_va-gender" id="gender_dropdown">
          <option value="m">Male</option>
          <option value="f">Female</option>
          <option value="o">Other</option>
        </select>

        <select name="_va-language" id="language_dropdown">
          <option value="EN">English</option>
          <option value="DE">German</option>
          <option value="FR">French</option>
          <option value="JA">Japanese</option>
          <option value="SP">Spanish</option>
        </select>

      </div>
      <input type="submit" id="suggestionbutton" value="Suggest Voice">

    </form>
  </div>
</body>

</html>