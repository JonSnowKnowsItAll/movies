<h1>Kinoprogramm</h1>
<br>
<?php
    if (isset($_POST['löschen']) and !isset($_POST['yes']) and !isset($_POST['no'])) {
        try 
        {
            $show = $_POST['löschen'];
            echo '<h6>Wollen Sie die Vorstellung wirklich löschen?</h6>'
            ?>
                <form method="post">
                    <input type="text" name="delete" value="<?php echo $show; ?>" hidden>
                    <button class="btn btn-outline-danger" type="submit" name="yes">Ja</button>
                    <button class="btn btn-outline-success" type="submit" name="no">Nein</button>
                </form>
            <?php
        } 
        catch (Exception $e) {
            echo 'Ups :( - Löschen fehlgeschlagen'.$e->getCode().': '.$e->getMessage();
        }
    }
    elseif (isset($_POST['yes'])) {
       try 
       {
            $show = $_POST['delete'];
            $deleteShow = 'delete from vorstellung
                           where vo_id = ?';
            $valueArray = array($show);

            $deleteShow = $con->prepare($deleteShow);
            $deleteShow->execute($valueArray);

            echo '<h6>Vorstellung gelöscht!</h6>';
            ?>
            <form method="post">
                <br>
                <button type="submit" class="btn btn-outline-info">zurück</button>
            </form>
            <?php

       } catch (Exception $e) {
            echo 'Ups :( - Löschen fehlgeschlagen'.$e->getCode().': '.$e->getMessage();
       }
    }
    else 
    {
        global $con;

        $getDates = "select distinct date_format(v.vo_uhrzeit, '%y-%m-%d')
                    from vorstellung v, film f, saal s
                where v.fi_id = f.fi_id
                    and v.sa_Id = s.sa_id
                order by v.vo_uhrzeit";
    
        $dates = makeStatement($getDates);
    
        while ($row = $dates->fetch(PDO::FETCH_NUM)) { 
            echo '<b style="color:seagreen">'.$row[0].'</b><br>';
            
            $getSchedule = 'select v.vo_id as "#", Concat_ws(" ",f.fi_titel , f.fi_titel2) as Titel, date_format(v.vo_uhrzeit, "%H:%i:%s") as Uhrzeit, s.sa_nr as Saal
                                from vorstellung v, film f, saal s
                            where v.fi_id = f.fi_id
                                and v.sa_Id = s.sa_id
                                and date_format(v.vo_uhrzeit, "%y-%m-%d") = cast("'.$row[0].'" as date)
                            order by v.vo_uhrzeit, s.sa_nr';
            
            ?>
            <form method="post">
                <?php
                showTablewithButton($getSchedule);
                ?>
            </form>'
            <?php               
        }
    }
