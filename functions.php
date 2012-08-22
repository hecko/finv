<?php

include("config.php");

function list_invoices($which) {

  include("db.php");

  if ($which == 0) {
    $invoices_sql = 'SELECT * FROM `invoices` ORDER BY `issued`,`id`';
  }

  $invoices_raw = mysql_query($invoices_sql);
  while ($invoices_row = mysql_fetch_array($invoices_raw,MYSQL_ASSOC)) {
    $invoice = get_invoice($invoices_row['id']);
    $invoice_list[] = $invoice;
  }

  return $invoice_list;
}

function hash_to_id($hash) {
  include("db.php");
  $hash_sql = 'SELECT id FROM `invoices` WHERE `hash`="'.$hash.'";';
  $hash_raw = mysql_query($hash_sql);
  $hash_row = mysql_fetch_array($hash_raw,MYSQL_ASSOC);

  return $hash_row['id'];
}

function get_invoice($id) {

  include("db.php");
  include("config.php");
  $invoice_sql = 'SELECT * FROM `invoices` WHERE `id`='.$id.';';
  $invoice_raw = mysql_query($invoice_sql);
  $invoice_row = mysql_fetch_array($invoice_raw,MYSQL_ASSOC);
  $data = $invoice_row;

  $from_sql = 'SELECT * FROM `firms` WHERE `id` IN (SELECT from_id FROM `invoices` WHERE `id`='.$id.')';
  $from_raw = mysql_query($from_sql);
  $from_row = mysql_fetch_array($from_raw,MYSQL_ASSOC);
  $data['from'] = $from_row;

  $to_sql = 'SELECT * FROM `firms` WHERE `id` IN (SELECT to_id FROM `invoices` WHERE `id`='.$id.')';
  $to_raw = mysql_query($to_sql);
  $to_row = mysql_fetch_array($to_raw,MYSQL_ASSOC);
  $data['to'] = $to_row;

  $items_sql = 'SELECT * FROM `items` WHERE `invoice_id`='.$id.';';
  $items_raw = mysql_query($items_sql);
  $data['price_total'] = 0;
  while ($item_row = mysql_fetch_array($items_raw,MYSQL_ASSOC)) {
    $data['items'][$item_row['id']] = $item_row;
    // ak nie je platca dph pripocitaj DPH do ceny itemu, ak je, tak vypocitaj VAT zvlast
    if ($data['from']['vat_payer']==0) {
      $data['items'][$item_row['id']]['orig_price'] = $data['items'][$item_row['id']]['price'];
      $data['items'][$item_row['id']]['price'] = $data['items'][$item_row['id']]['price'] * (1+$c['vat']) ;
      $data['items'][$item_row['id']]['vat'] = 0;
    } else {
      $data['items'][$item_row['id']]['orig_price'] = $data['items'][$item_row['id']]['price'];
      $data['items'][$item_row['id']]['vat'] = round($data['price_total']*$c['vat'],2);
    }
    $data['vat_total'] += $data['items'][$item_row['id']]['vat'];
    $data['price_total'] += $data['items'][$item_row['id']]['price'];
  }

  $data['issued_human'] = date("d. M Y",strtotime($data['issued']));
  $data['vat_percent'] = $c['vat'] * 100;
  $data['payable'] = round($data['price_total']+$data['vat'],2);

  $data['currency'] = 'EUR';
   
  return $data;

}

?>
