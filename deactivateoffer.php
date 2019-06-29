<?php
include ('include/connection.php');
session_start();

if (!isset($_GET['offerid'])) // دا عشان لو هو جايلى الصفحة من غير رقم لاى اوفر ارجعه تانى عشان اريح دماغى دا اولا
{
    header('location:storeSeller.php');
}
$option = intval($_GET['option']);
$offer_number = intval($_GET['offerid']); // not important intval() put more security ^_^
if (!is_int($offer_number))
{
    echo 'You Must Get an offer Number'; // error message ^_^
}
$GetOfferQuery = "update offer set deleted = '$option' where offer_number=".$offer_number;
$q = mysqli_query($conn, $GetOfferQuery);
header('location:storeSeller.php');