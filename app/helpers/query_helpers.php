<?
function getResults($dbContext)
{
    $results = $dbContext->execute();
    if ($dbContext->rowCount($results) == 0) {
        return [];
    } else {
        $results = $dbContext->resultSet();
        return $results;
    }

    return $results;
}

function execQueryRetTrueOrFalse($dbContext){
    if ($dbContext->execute()) {
        return true;
    }
    return false;
}