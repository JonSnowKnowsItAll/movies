<?php 
function makeStatement($query, $valueArray = null)
{
    global $con;
    $stmt = $con->prepare($query);
    $stmt->execute($valueArray);
    return $stmt;
}

function showTable($query)
{
    global $con;
    $stmt = $con->prepare($query);
    $stmt->execute();
    $meta = array(); //save attribute properties

    echo '<table class="table"><tr>';

    //column name
    for ($i = 0; $i < $stmt->columnCount(); $i++) {
        $meta[] = $stmt->getColumnMeta($i); //attribute properties
        echo '<th>' . $meta[$i]['name'] . '</th>';
    }
    echo '</tr>';

    while ($row = $stmt->fetch(PDO::FETCH_NUM))
    {
        echo '<tr>';
        foreach ($row as $r)
        {
            echo '<td>' . $r . '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
}

function showTablewithButton($query)
{
    global $con;
    $stmt = $con->prepare($query);
    $stmt->execute();
    $meta = array(); //save attribute properties

    echo '<table class="table"><tr>';

    //column name
    for ($i = 0; $i < $stmt->columnCount(); $i++) {
        $meta[] = $stmt->getColumnMeta($i); //attribute properties
        echo '<th>' . $meta[$i]['name'] . '</th>';        
    }
    echo '<th></th>';
    echo '</tr>';

    while ($row = $stmt->fetch(PDO::FETCH_NUM))
    {
        echo '<tr>';
        foreach ($row as $r)
        {
            echo '<td>' . $r . '</td>';
        }
        echo '<td><button class="btn btn-outline-danger" type="submit" name="löschen" value="'.$row[0].'">löschen</button></td>';
        echo '</tr>';
    }
    echo '</table>';
}

function showTableWithColor($query, $value=null)
{
    global $con;
    $stmt = $con->prepare($query);
    $stmt->execute();
    $meta = array(); //save attribute properties

    echo $value;
    echo '<table class="table"><tr>';

    //column name
    for ($i = 0; $i < $stmt->columnCount(); $i++) {
        $meta[] = $stmt->getColumnMeta($i); //attribute properties
        echo '<th>' . $meta[$i]['name'] . '</th>';
    }
    echo '</tr>';

    while ($row = $stmt->fetch(PDO::FETCH_NUM))
    {
        $row = array_values($row);
        print_r($row);
        if($row[0] == $value)
        {
            echo 'if';
            echo '<tr style="color:red">';
        }
        else
        {   
            echo 'else';
            echo '<tr>';
        }
        
        foreach ($row as $r)
        {
            echo '<td>' . $r . '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
}
