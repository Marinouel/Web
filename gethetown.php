<?php
// Array with names
$a[] = "ΙΩΑΝΝΙΝΑ";
$a[] = "ΘΕΣΣΑΛΟΝΙΚΗ";
$a[] = "ΑΛΕΞΑΝΔΡΟΥΠΟΛΗ";
$a[] = "ΠΑΤΡΑ";
$a[] = "ΛΑΡΙΣΑ";
$a[] = "ΜΥΤΙΛΗΝΗ";
$a[] = "ΚΑΛΑΜΑΤΑ";
$a[] = "ΑΘΗΝΑ";
$a[] = "ΗΡΑΚΛΕΙΟ";

$b[] = "45221";
$b[] = "54630";
$b[] = "68100";
$b[] = "26223";
$b[] = "41335";
$b[] = "81100";
$b[] = "24100";
$b[] = "10433";
$b[] = "71500";


//---------------------TOWN---------------------------------------------
// get the q parameter from URL
$q = $_REQUEST["q"];

$hint = "";

// lookup all hints from array if $q is different from "" 
if ($q !== "") {
    $q = strtolower($q);
    $len=strlen($q);
    foreach($a as $name) {
        if (stristr($q, substr($name, 0, $len))) {
            if ($hint === "") {
                $hint = $name;
            } else {
                $hint .= ", $name";
            }
        }
    }
}

// Output "no suggestion" if no hint was found or output correct values 
echo $hint === "" ? "no suggestion" : $hint;
//----------------------------------------------------------------------
//
//---------------------TK-----------------------------------------------
// get the q parameter from URL
$q = $_REQUEST["q"];

$hint = "";

// lookup all hints from array if $q is different from "" 
if ($q !== "") {
    $q = strtolower($q);
    $len=strlen($q);
    foreach($b as $name) {
        if (stristr($q, substr($name, 0, $len))) {
            if ($hint === "") {
                $hint = $name;
            } else {
                $hint .= ", $name";
            }
        }
    }
}

// Output "no suggestion" if no hint was found or output correct values 
echo $hint === "" ? "no suggestion" : $hint;
?> 