<?php

include("functions.php");
include("lang.php");

$id = hash_to_id($_GET['h']);

$d = get_invoice($id);

?>

<style>
html {
  font-family: arial;
}
tr {
  border-bottom: 1px solid;
}
td {
  text-align: left;
  vertical-align: top;
  font-size: 14px;
  border: 0px solid;
}
table {
  border: 1px solid;
}
.item {
  background-color: #ffcccc;
  border-bottom: 2px solid;
}
</style>

<table width=80%>
<tr>
  <td colspan=2>
    <? echo $l['Invoice'][$d['lang']]; ?><hr>
    variabilny symbol: <? echo date("Ymd",strtotime($d['issued'])).$d['id']; ?><br>
    datum vydania: <? echo date("d. M Y",strtotime($d['issued'])) ?><br>
    datum splatnosti: 11 pracovnych dni od datumu vydania
  </td>
</tr>
<tr>
  <td>Vystavil:<hr><? echo nl2br($d['from']['description']) ?></td>
  <td>Pre:<hr><? echo nl2br($d['to']['description']) ?></td>
</tr>
<tr>
  <td colspan=2>
    <table width=100%>
      <? 
        foreach($d['items'] as $i) {
          echo '<tr class=item><td colspan=2 class=item>'.$i['description'].'</td><td width=90 style="text-align: right">'.$i['price'].' '.$d['currency'].'</td></tr>';
        }
      ?>
      <tr><td></td><td width=200>Cena spolu</td><td style="text-align: right"><? echo $d['price_total'].' '.$d['currency']; ?></td></tr>
      <tr><td></td><td width=200>DPH (<? echo $d['vat_percent'] ?>%)</td><td style="text-align: right"><? echo $d['vat_total'].' '.$d['currency']; ?></td></tr>
      <tr><td></td><td width=200>Spolu k zaplateniu</td><td style="text-align: right" class=item><? echo $d['payable'].' '.$d['currency']; ?></td></tr>
    </table>
  </td>
</tr>
<tr><td colspan=2><br><br><br><br><br><br><br></td></tr>
</table>
