<html>
 <head>
  <title>PHP Test with OCI_Connect</title>
 </head>
 <body>
 <?php echo '<p>Establishing a connection to an Oracle database.</p>';


// establish a database connection to your Oracle database.
$username = 's3766925';
$password = '9394azpokr';
$servername = 'talsprddb01.int.its.rmit.edu.au';
$servicename = 'CSAMPR1.ITS.RMIT.EDU.AU';
$connection = $servername."/".$servicename;

$conn = oci_connect($username, $password, $connection);

if(!$conn)
{
    
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
else
{
    echo "<p>Successfully connected to CSAMPR1.ITS.RMIT.EDU.AU.</p>";

    // testing generic SELECT SQL 
    $stid = oci_parse($conn, 'SELECT sysdate FROM dual');

    // The define MUST be done before executing
    oci_define_by_name($stid, 'SYSDATE', $oracle_sys_date);

    oci_execute($stid);

    // Each fetch populates the previously defined variables with the next row's data
    while (oci_fetch($stid))
    {
        echo "Current System Date in Oracle Database is $oracle_sys_date<br>\n";
    }


    // testing SELECT SQL from movie table
    $stid = oci_parse($conn, 'SELECT * FROM movie');
    oci_execute($stid);

    echo "<table border='1'>\n";

    $ncols = oci_num_fields($stid);

    echo "<tr>";

    // Build HTML table Header using fieldnames from Oracle Table
    for ($i = 1; $i <= $ncols; $i++) {
        $column_name  = oci_field_name($stid, $i);
        $column_type  = oci_field_type($stid, $i);

        echo "<td><B>$column_name";
        echo " ($column_type)</B></td>";
    }
    echo "</tr>\n";

    // Populate the table with data fetched from the Oracle table
    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
        echo "<tr>\n";
        foreach ($row as $item) {
            echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
        }
        echo "</tr>\n";
    }
    echo "</table>\n";
}

oci_close($conn);

?>

 </body>
</html>