<?php
global $con;
if (isset($_POST['save']) and isset($_POST['title']) and isset($_POST['title2']) and isset($_POST['date'])) {
    $movieTitle = $_POST['title'];

    $movieSubtitle = $_POST['title2'];

    $movieDate = $_POST['date'];

    $addMovie = 'insert into film (fi_titel, fi_titel2, fi_erscheinung)
	             values (?, ?, cast(? as date))';

    $valueArray = array($movieTitle, $movieSubtitle, $movieDate);
    $addMovie = $con->prepare($addMovie);
    $addMovie->execute($valueArray);

    echo '<h6>Der Film <b>'.$movieTitle.'</b> wurde hinzugefügt!</h6>';

    $showAllMovies = ' select fi_titel as "Titel", fi_titel2 as "Subtitel",  fi_erscheinung as "Erscheinungsjahr" 
                         from film
                        order by fi_id desc';

    showTableWithColor($showAllMovies, $movieTitle);
    echo '<form method="post"><button class="btn btn-outline-info" name="zurück" type="submit">zurück</button></form>';
}
else 
{
    ?>
    <h1>Film hinzufügen</h1>
    <form method="post">
        <br>
        <label for="title">*Titel eingeben:</label>
        <input class="form-control" type="text" name="title" required>
        <br>
        <label for="title2">Untertitel eingeben:</label>
        <input class="form-control" type="text" name="title2">
        <br>
        <label for="date">*Erscheinungsdatum:</label>
        <input class="form-control" type="date" name="date" required>
        <br>
        <button class="btn btn-outline-info" type="submit" name="save">speichern</button>
    </form>
    <hr>
    <?php
    echo '<br><h6>Verfügbare Filme:</h6>';
    $availableMovies = 'select concat_ws(" ", fi_titel, fi_titel2) as "Titel", fi_erscheinung as "Erscheinungsjahr" 
    from film';

    showTable($availableMovies);
}