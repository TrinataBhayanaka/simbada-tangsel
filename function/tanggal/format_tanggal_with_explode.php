 <?php

function format_tanggal($tgl) {
    if($tgl!="0000-00-00" && $tgl!="")
    {
          $temp=explode(" ", $tgl);
          $temp=explode("-", $temp[0]);
          $tahun=$temp[0];
          $bln=$temp[1];
          $hari=$temp[2];


        switch($bln)
        {
            case "01" : $namaBln = "Januari";
                      break;
            case "02" : $namaBln = "Februari";
                      break;
            case "03" : $namaBln = "Maret";
                       break;
            case "04" : $namaBln = "April";
                       break;
            case "05" : $namaBln = "Mei";
                     break;
            case "06" : $namaBln = "Juni";
                     break;
            case "07" : $namaBln = "Juli";
                     break;
            case "08" : $namaBln = "Agustus";
                     break;
            case "09" : $namaBln = "September";
                     break;
            case "10" : $namaBln = "Oktober";
                     break;
            case "11" : $namaBln = "November";
                         break;
            case "12" : $namaBln = "Desember";
                         break;
        }
        $tgl_full="$hari $namaBln $tahun";
        return $tgl_full;
    }
    else return "";
}

function format_tanggal_db($tgl) {
    if($tgl!="")
    {
          $temp=explode(" ", $tgl);
          $hari=$temp[0];
          $bln=$temp[1];
          $tahun=$temp[2];


        switch($bln)
        {
            case "Jan" : $namaBln = "01";
                      break;
            case "Feb" : $namaBln = "02";
                      break;
            case "Mar" : $namaBln = "03";
                       break;
            case "Apr" : $namaBln = "04";
                       break;
            case "Mei" : $namaBln = "05";
                     break;
            case "Jun" : $namaBln = "06";
                     break;
            case "Jul" : $namaBln = "07";
                     break;
            case "Agu" : $namaBln = "08";
                     break;
            case "Sep" : $namaBln = "09";
                     break;
            case "Okt" : $namaBln = "10";
                     break;
            case "Nov" : $namaBln = "11";
                         break;
            case "Des" : $namaBln = "12";
                         break;
        }
        $tgl_full="$tahun-$namaBln-$hari ";
        return $tgl_full;
    }
    else return "";
}

function format_tanggal_db2($tgl){
//30/06/2012
$temp=explode("/",$tgl);
 
$hasil=$temp[2]."-".$temp[1]."-".$temp[0];
return $hasil;
 
} 
 
function format_tanggal_db3($tgl){
//30/06/2012
$temp=explode("-",$tgl);
 
$hasil=$temp[2]."/".$temp[1]."/".$temp[0];
return $hasil;
 
}  
?>