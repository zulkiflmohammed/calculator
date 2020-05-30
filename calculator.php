<!-- calculator.php - handles backend logics for front-end requests 
    Written by: Zulkifl Mohammed
    Written:    5/29/20
    Revised:   
    -->
<?php
require_once('db-config.php');

// Get calculation request
if (isset($_POST['getCalculations'])) {

    // stores formatted calculations output
    $output = '';

    // Call getAllCalculations method to get calculations from db
    $calculationsResult = getAllCalculations($conn);
    
    while ($thisRow = mysqli_fetch_assoc($calculationsResult)) {
        $output .= '  
        <p>' . $thisRow["expression"] . '</p>
        <hr />
        ';
    }
    echo $output;
}

// Create calculation request
if (isset($_POST['createCalculation'])) {

    // Escape input for security
    $expression = mysqli_real_escape_string($conn, $_POST['expression']);

    // Call createCalculation method to save to db
    $calculationResult = createCalculation($conn, $expression);
    if ($calculationResult) {
        echo ("Calculation Added");
    }

    
}

// Gets all calculations from db
function getAllCalculations($conn)
{
    // execute stored procedure getAllCalculations
    $sql = "CALL getAllCalculations();";
    $result = $conn->query($sql);
    $conn->next_result();
    echo $conn->error;
    return $result;
}


function createCalculation($conn, $expression)
{
    // execute stored procedure createCalculation
    $sql = "CALL createCalculation('$expression', CURRENT_TIMESTAMP);";
    $result = $conn->query($sql);
    $conn->next_result();
    echo $conn->error;
    return $result;
}

?>
