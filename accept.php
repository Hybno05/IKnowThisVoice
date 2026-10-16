<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

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
    $connect_db = mysqli_connect("localhost", "root", "") or die("Keine Verbindung zum Datenbankserver");
    mysqli_select_db($connect_db, "iktv") or die("Datenbank existiert nicht");

    // Alle Funktionen, die auf der Seite verwendet werden
    function remove_suggestion($ID)
    {
        $connect_db = mysqli_connect("localhost", "root", "") or die("Keine Verbindung zum Datenbankserver");
        mysqli_select_db($connect_db, "iktv") or die("Datenbank existiert nicht");
        $query = "DELETE FROM suggestion WHERE ID = $ID";
        mysqli_query($connect_db, $query) or die("Anfrage gescheitert: " . mysqli_error($connect_db));
    }
    function test_input($data)
    {
        echo "test_input worked";
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }


    echo "<h1 id=\"überschrift\" style=\"text-align: center;\">I know this voice!</h1>";


    // Übernahme der Daten aus der Datenbank

    $query = "SELECT * FROM suggestion";
    $suggested = mysqli_query($connect_db, $query) or die("Anfrage gescheitert: " . mysqli_error($connect_db));
    $sugg_array = mysqli_fetch_assoc($suggested);
    for ($i = 0; $i < mysqli_num_rows($suggested); $i++) {
        $ca_firstname = $sugg_array["cFirstName"];
        $ca_surname = $sugg_array["cSurname"];
        $ca_nickname = $sugg_array["cNickname"];
        $ca_gender = $sugg_array["cGender"];
        $series = $sugg_array["cSeries"];
        $season = $sugg_array["cSeason"];
        $movie = $sugg_array["cMovie"];
        $videogame = $sugg_array["cVideogame"];
        $va_firstname = $sugg_array["vaFirstName"];
        $va_surname = $sugg_array["vaSurname"];
        $va_gender = $sugg_array["vaGender"];
        $va_language = $sugg_array["vaLanguage"];
        $sugg_ID = $sugg_array["ID"];
    ?>

        <!-- Darstellung der einzelnen Vorschläge in Visitenkarten-->
        <div class="form-container">
            <div class="visitenkarten_container">
                <div class="visitenkarten">
                    <div class="hauptContainer">
                        <div class="containerBeschreibung">

                            <!-- Richtige Daten werden in Visitenform angezeigt -->
                            <ul id="charakterbeschreibung">
                                <?php
                                echo "<li><span>Vorname: " . $sugg_array["cFirstName"] . "</span></li>";
                                if ($sugg_array["cSurname"] != NULL) {
                                    echo "<li><span>Nachname: " .  $sugg_array["cSurname"] . "</span></li>";
                                }
                                if ($sugg_array["cNickname"] != NULL) {
                                    echo "<li><span>Nickname: " .  $sugg_array["cNickname"] . "</span></li>";
                                }
                                echo "<li><span>Geschlecht: " .  $sugg_array["cGender"] . "</span></li>";
                                echo "<li><span>Synchronsprecher: " . $sugg_array["vaFirstName"] . " " . $sugg_array["vaSurname"] . "</span></li>";
                                echo "<li><span>Synchronsprache: " .  $sugg_array["vaLanguage"] . "</span></li>";
                                if ($sugg_array["cSeries"] != NULL) {
                                    echo "<li><span>Serie: " .  $sugg_array["cSeries"] . "</span></li>";
                                }
                                if ($sugg_array["cMovie"] != NULL) {
                                    echo "<li><span>Film: " .  $sugg_array["cMovie"] . "</span></li>";
                                }
                                if ($sugg_array["cVideogame"] != NULL) {
                                    echo "<li><span>Videospiel: " .  $sugg_array["cVideogame"] . "</span></li>";
                                }
                                ?>
                            </ul>

                        </div>
                    </div>
                </div>


            <?php

            // Vorschlag soll akzeptiert werden
            if (array_key_exists('accept', $_POST)) {
                $ID = preg_replace('/[^0-9]/', '', $_POST['accept']);
                $connect_db = mysqli_connect("localhost", "root", "") or die("Keine Verbindung zum Datenbankserver");
                mysqli_select_db($connect_db, "iktv") or die("Datenbank existiert nicht");
                switch ($sugg_array["vaGender"]) {
                    case "m":
                        $sugg_array["vaGender"] = 1;
                        break;
                    case "f":
                        $sugg_array["vaGender"] = 2;
                        break;
                    case "o":
                        $sugg_array["vaGender"] = 3;
                        break;
                }
                switch ($sugg_array["cGender"]) {
                    case "m":
                        $sugg_array["cGender"] = 1;
                        break;
                    case "f":
                        $sugg_array["cGender"] = 2;
                        break;
                    case "o":
                        $sugg_array["cGender"] = 3;
                        break;
                }
                switch ($sugg_array["vaLanguage"]) {
                    case "en":
                        $sugg_array["vaLanguage"] = 1;
                        break;
                    case "de":
                        $sugg_array["vaLanguage"] = 2;
                        break;
                    case "fr":
                        $sugg_array["vaLanguage"] = 3;
                        break;
                    case "ja":
                        $sugg_array["vaLanguage"] = 4;
                        break;
                    case "sp":
                        $sugg_array["vaLanguage"] = 5;
                        break;
                }
                /* Subqueries müssen im Format -> INSERT INTO [table] SELECT ... angegeben werden, weitere Daten müssen mit JOINS angegeben werden */
                $query = "INSERT INTO charakter (cFirstName, cSurname, cNickname, gId) 
                SELECT cFirstName, cSurname, cNickname, cGender FROM suggestion WHERE ID = ".$ID.";
                -- Die Beschreibung und das passende Bild des Charakters wird per Name über die API abgerufen.
                -- Bild, Geburts- und Todesdatum/Zeit wird ebenfalls mit der API übernommen
                INSERT INTO voice_actor(vaFirstName, vaSurname, gId) SELECT vaFirstName,vaSurname,vaGender FROM suggestion WHERE ID =".$ID."; 
                INSERT INTO va_lang(vaId, lId) 
                SELECT voice_actor.vaId, lang.lId FROM voice_actor 
                JOIN suggestion ON voice_actor.vaFirstName = suggestion.vaFirstName 
                JOIN lang ON lang.lShort = suggestion.vaLanguage WHERE suggestion.ID =".$ID.";
                INSERT INTO va_char(cId, valId) 
                SELECT charakter.cId, va_lang.valId FROM charakter 
                JOIN suggestion ON charakter.cFirstName = suggestion.cFirstName 
                JOIN voice_actor ON voice_actor.vaFirstName = suggestion.vaFirstName 
                JOIN lang ON lang.lShort = suggestion.vaLanguage 
                JOIN va_lang ON va_lang.vaId = voice_actor.vaId AND va_lang.lId = lang.lId WHERE suggestion.ID =".$ID.";
                -- Franchise muss mithilfe der API an die jeweiligen Bereiche eingefügt werden. Die API sucht anhand der Namen des Films/der Serie/des Spiels das Franchise heraus.
                /*INSERT INTO movie(mName) 
                SELECT cMovie FROM suggestion WHERE ID =".$ID.";
                INSERT INTO video_game(vName) 
                SELECT cVideogame FROM suggestion WHERE ID =".$ID.";
                INSERT INTO series(seName) 
                SELECT cSeries FROM suggestion WHERE ID =".$ID.";
                -- Die Informationen über die Seasons wie EpisodeCount müssen über die API abgefragt werden.
                INSERT INTO season(seaNr, seId, seaEpisodeCount) 
                SELECT suggestion.cSeason, series.seId, suggestion.seaEpisodeCount FROM suggestion 
                JOIN series ON series.seName = suggestion.cSeries WHERE suggestion.ID =".$ID.";
                -- vacAge wird ebenfalls über die API anhand des Charakters angepasst*/
                ";

                $movie_query = "SELECT cMovie FROM suggestion WHERE ID = ".$ID."";
                if(mysqli_query($connect_db, $movie_query) == '') {
                        $query .= " INSERT INTO movie(mName) SELECT cMovie FROM suggestion WHERE ID =".$ID.";";
                }

                $videogame_query = "SELECT cVideogame FROM suggestion WHERE ID = ".$ID."";
                if(mysqli_query($connect_db, $videogame_query) == '') {
                        $query .= " INSERT INTO video_game(vName) SELECT cVideogame FROM suggestion WHERE ID =".$ID.";";
                }

                $series_query = "SELECT cSeries FROM suggestion WHERE ID = ".$ID."";
                if(mysqli_query($connect_db, $series_query) == '') {
                $query .=" INSERT INTO series(seName) SELECT cSeries FROM suggestion WHERE ID = ".$ID."; 
                -- Die Informationen über die Seasons wie EpisodeCount müssen über die API abgefragt werden. 
                INSERT INTO season(seaNr, seId, seaEpisodeCount) 
                SELECT suggestion.cSeason, series.seId, suggestion.seaEpisodeCount FROM suggestion 
                JOIN series ON series.seName = suggestion.cSeries WHERE suggestion.ID =".$ID.";";
                }
                
                $query .=" INSERT INTO content_cva(vId, mId, seaId, vacId, vacAge) 
                SELECT vId, mId, seaId, vacId, cAge FROM video_game 
                JOIN suggestion ON suggestion.cVideogame = video_game.vName 
                JOIN movie ON movie.mName=suggestion.cMovie 
                JOIN series ON series.seName = suggestion.cSeries 
                JOIN season ON season.seId = series.seId
                JOIN charakter ON charakter.cFirstName=suggestion.cFirstName
                JOIN voice_actor ON voice_actor.vaFirstName=suggestion.vaFirstName 
                JOIN lang ON lang.lShort = suggestion.vaLanguage 
                JOIN va_lang ON va_lang.vaId = voice_actor.vaId AND va_lang.lId = lang.lId
                JOIN va_char ON va_char.valId = va_lang.valId AND va_char.cId = charakter.cId WHERE suggestion.ID =".$ID.";
                DELETE FROM suggestion WHERE ID = ". $ID.";
                ";           
               

                /* $ergebnis hat den Datentyp "mysqli_result" */
                $ergebnis =  mysqli_multi_query($connect_db, $query) or die("Anfrage gescheitert: " . mysqli_error($connect_db));
                header("Refresh: 1");
                // Vorschlag soll angepasst werden
            } elseif (array_key_exists('edit', $_POST)) {



                if (array_key_exists('edit_confirm', $_POST)) {
                    $ID = preg_replace('/[^0-9]/', '', $_POST['edit']);
                    echo $ID;
                    foreach ($_POST as $key => $value) {
                        echo "Key: " . $key . " Value: " . $value . "<br>";
                    }
                    if (isset($_POST["_edit_ca-firstname"]) && isset($_POST["_edit_va-firstname"]) && isset($_POST["_edit_va-surname"])) {
                        $edit_ca_firstname = test_input($_POST["_edit_ca-firstname"]);
                        echo "edit_ca_firstname: " . $edit_ca_firstname;
                        if ($_POST["_edit_ca-surname"] == "") {
                            $edit_ca_surname = NULL;
                        } else {
                            $edit_ca_surname = test_input($_POST["_edit_ca-surname"]);
                        }
                        if ($_POST["_edit_ca-nickname"] == "") {
                            $edit_ca_nickname = NULL;
                        } else {
                            $edit_ca_nickname = test_input($_POST["_edit_ca-nickname"]);
                        }
                        $edit_ca_gender = test_input($_POST["_edit_ca-gender"]);

                        if ($_POST["_edit_series"] == "") {
                            $edit_series = NULL;
                        } else {
                            $edit_series = test_input($_POST["_edit_series"]);
                        }
                        if ($_POST["_edit_movie"] == "") {
                            $edit_movie = NULL;
                        } else {
                            $edit_movie = test_input($_POST["_edit_movie"]);
                        }
                        if ($_POST["_edit_videogame"] == "") {
                            $edit_videogame = NULL;
                        } else {
                            $edit_videogame = test_input($_POST["_edit_videogame"]);
                        }

                        $edit_va_firstname = test_input($_POST["_edit_va-firstname"]);
                        if ($_POST["_edit_va-surname"] == "") {
                            $edit_va_surname = NULL;
                        } else {
                            $edit_va_surname = test_input($_POST["_edit_va-surname"]);
                        }
                        $edit_ca_gender = test_input($_POST["_edit_ca-gender"]);
                        $edit_va_language = test_input($_POST["_edit_va-language"]);


                        /*$daten = json_encode(array(
                            "ca_firstname" => $edit_ca_firstname,
                            "ca_surname" => $edit_ca_surname,
                            "ca_nickname" => $edit_ca_nickname,
                            "ca_gender" => $edit_ca_gender,
                            "series" => $edit_series,
                            "movie" => $edit_movie,
                            "videogame" => $edit_videogame,
                            "va_firstname" => $edit_va_firstname,
                            "va_surname" => $edit_va_surname,
                            "va_language" => $edit_va_language
                        ), JSON_PRETTY_PRINT);


                        $filepath = "/opt/lampp/htdocs/Suggestions/";
                        file_put_contents($filepath . "suggestion-" . $edit_ca_firstname . ".json", $daten);*/

                        $daten = "(\"" . $edit_ca_firstname . "\",\"" . $edit_ca_surname . "\",\"" . $edit_ca_nickname . "\",\"" . $edit_ca_gender . "\",\"" . $edit_series . "\",\"" . $edit_movie . "\",\"" . $edit_videogame . "\",\"" . $edit_va_firstname . "\",\"" . $edit_va_surname . "\",\"" . $edit_va_language . "\")";
                        $connect_db = mysqli_connect("localhost", "root", "") or die("Keine Verbindung zum Datenbankserver");
                        mysqli_select_db($connect_db, "iktv") or die("Datenbank existiert nicht");

                        $query = "DELETE FROM suggestion WHERE ID = " . $ID . ";
                                INSERT INTO suggestion(cFirstName, cSurname, cNickname ,cGender, cSeries, cMovie, cVideogame, vaFirstName, vaSurname,vaGender, vaLanguage) VALUES ($daten);";



                        mysqli_query($connect_db, $query) or die("Anfrage gescheitert: " . mysqli_error($connect_db));

                        header("Refresh:1");
                    }
                }



                echo "<form method=\"post\" autocomplete=\"off\" id=\"suggestionForm\">
      <!-- Input of Character Name -->
      <p>
        Edit the suggested Character:
      </p>
      <div class=\"input-container\">

        <input type=\"text\" id=\"firstname\" class=\"suggestionForm\" autofocus placeholder=\"Character-Firstname\"
          value=\"" . $sugg_array["cFirstName"] . "\" name=\"_edit_ca-firstname\">

        <input type=\"text\" id=\"surname\" class=\"suggestionForm\" autofocus placeholder=\"Character-Surname\"
          value=\"" . $sugg_array["cSurname"] . "\" name=\"_edit_ca-surname\">

        <input type=\"text\" id=\"nickname\" class=\"suggestionForm\" autofocus placeholder=\"Character-Nickname\"
          value=\"" . $sugg_array["cNickname"] . "\" name=\"_edit_ca-nickname\">
      </div>
      <select name=\"_edit-ca-gender\" id=\"gender_dropdown\">
        <option value=\"m\"";
                if ($sugg_array["vaGender"] == "m") {
                    echo "selected";
                }
                echo ">Male</option>
        <option value=\"f\"";
                if ($sugg_array["vaGender"] == "f") {
                    echo "selected";
                }
                echo ">Female</option>
        <option value=\"o\"";
                if ($sugg_array["vaGender"] == "o") {
                    echo "selected";
                }
                echo ">Other</option>
      </select>
      <p>
        Here you can edit the Series/Movie/VideoGame the Character is voiced in:
      </p>
      <!-- Input of Chracter Series/Movie/VideoGame -->
      <div class=\"input-container\">
        <input type=\"text\" id=\"series\" class=\"suggestionForm\" autofocus placeholder=\"Series\"
          value=\"" . $sugg_array["cSeries"] . "\" name=\"_edit_series\">

        <input type=\"text\" id=\"movie\" class=\"suggestionForm\" autofocus placeholder=\"Movie\"
          value=\"" . $sugg_array["cMovie"] . "\" name=\"_edit_movie\">

        <input type=\"text\" id=\"videogame\" class=\"suggestionForm\" autofocus placeholder=\"Video Game\"
          value=\"" . $sugg_array["cVideogame"] . "\" name=\"_edit_videogame\">
      </div>
      <p>
        Edit the Name of the Voice Actor who voices the Character and their specified language:
      </p>
      <!-- Input of Voice Actor Name-->
      <div class=\"input-container\">
        <input type=\"text\" id=\"voice_actor_firstname\" class=\"suggestionForm\" autofocus placeholder=\"Firstname of Voice Actor\"
          value=\"" . $sugg_array["vaFirstName"] . "\" name=\"_edit_va-firstname\">
        <input type=\"text\" id=\"voice_actor_surname\" class=\"suggestionForm\" autofocus placeholder=\"Surname of Voice Actor\"
          value=\"" . $sugg_array["vaSurname"] . "\" name=\"_edit_va-surname\">


        <select name=\"_edit_va-language\" id=\"language_dropdown\">
          <option value=\"en\"";
                if ($sugg_array["vaLanguage"] == "en") {
                    echo "selected";
                }
                echo ">English</option>
          <option value=\"de\"";
                if ($sugg_array["vaLanguage"] == "de") {
                    echo "selected";
                }
                echo ">German</option>
          <option value=\"fr\"";
                if ($sugg_array["vaLanguage"] == "fr") {
                    echo "selected";
                }
                echo ">French</option>
          <option value=\"ja\"";
                if ($sugg_array["vaLanguage"] == "ja") {
                    echo "selected";
                }
                echo ">Japanese</option>
          <option value=\"sp\"";
                if ($sugg_array["vaLanguage"] == "sp") {
                    echo "selected";
                }
                echo ">Spanish</option>
        </select>
      </div>
      <input type=\"submit\" name=\"edit_confirm\" id=\"suggestionbutton\" value=\"Confirm Edit\">

    </form>";

                //Vorschlag wird abgelehnt und aus der Datenbank gelöscht
            } elseif (array_key_exists('decline', $_POST)) {
                $ID = preg_replace('/[^0-9]/', '', $_POST['decline']);
                remove_suggestion($ID);
                header("Refresh:1");
                break;
            }
            echo "<form method=\"post\">";
            echo "<input type=\"submit\" name=\"accept\" value=\"Accept" . $sugg_array["ID"] . "\"/>";
            echo "<input type=\"submit\" name=\"edit\" value=\"Edit" . $sugg_array["ID"] . "\" />";
            echo "<input type=\"submit\" name=\"decline\" value=\"Decline" . $sugg_array["ID"] . "\" />";
            echo "</form>";
            echo "</div>";
            echo "<br><hr class=\"trennlinie\" id=\"trennlinieZwischen\"><br>";
            echo "</div>";
            $sugg_array = mysqli_fetch_assoc($suggested);
        }

            ?>
</body>

</html>