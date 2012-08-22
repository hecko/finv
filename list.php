<?php

include("functions.php");

$invoices = list_invoices(0);

?>

<html>

<style>
table, tr, td {
  border: 1px solid;
}
</style>

<table>
<?php
foreach ($invoices as $i) {
  echo '<tr><td><a href="i.php?h='.$i['hash'].'">'.$i['id'].' / '.$i['to']['description'].'</a></td>
    <td>'.$i['payable'].'</td>
    <td>'.$i['issued_human'].'</td>
    </tr>';
}
?>
</table>
