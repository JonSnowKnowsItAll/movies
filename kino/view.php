<h1>Vorstellung hinzufügen</h1>
<form method="post">
    <?php
        global $con;
        $getMovies = 'select fi_id, concat_ws(" ", fi_titel, fi_titel2) as Titel
                        from film';

        $movies = makeStatement($getMovies);

        echo '<label for="movie">Film auswählen: </label>';
        echo '<select class="form-control" name="movie" required>';
        while ($row = $movies->fetch(PDO::FETCH_NUM)) {
          echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
        }
        echo '</select>';

        $getRoom = 'select sa_id, concat(sa_nr, " - ", sa_name) as Saal
                      from saal';

        $room = makeStatement($getRoom);

        echo '<br><label for="room">Saal auswählen: </label>';
        echo '<select class="form-control" name="room" required>';
        while ($row = $room->fetch(PDO::FETCH_NUM)) {
          echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
        }
        echo '</select>';
    ?>   
        <br><label for="datetime">Uhrzeit auswählen: </label> 
        <input class="form-control" type="datetime-local" name="datetime" required>
        <br>
        <button type="submit" class="btn btn-outline-info" name="speichern">speichern</button>
</form>
<?php
if (isset($_POST['speichern']) && isset($_POST['movie']) && isset($_POST['room']) && isset($_POST['datetime'])) {
    try {
       $movie = $_POST['movie'];
       $room = $_POST['room'];
       $datetime = $_POST['datetime'];

       $saveShow = 'insert into vorstellung (fi_id, sa_id, vo_uhrzeit)
                    values (?, ?, cast(? as datetime))';

       $valueArray = array($movie, $room, $datetime);

       $saveShow = $con->prepare($saveShow);
       $saveShow->execute($valueArray);

       echo '<hr><h6>Die Vorstellung wurde im Saal '.$room.' um '.$datetime.' gebucht!</h6>';



    } catch (Exception $e) {
        echo '<p style="color:red">Ups :( - beim Speichern der Vorstellung ist etwas schief gelaufen</p><br>'.$e->getCode().': '.$e->getMessage();
    }
}