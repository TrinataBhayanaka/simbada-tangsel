<?php
ob_start();
include "../config/config.php";



$id=$_SESSION['user_id'];//Nanti diganti

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
#This code provided by:
#Andreas Hadiyono (andre.hadiyono@gmail.com)
#Gunadarma University

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

/* Array of database columns which should be read and sent back to DataTables. Use a space where
 * you want to insert a non-database field (for example a counter or static image)
 */

$aColumns = array('a.Aset_ID','a.noRegister','a.noKontrak','k.Uraian','a.kodeSatker','a.TglPerolehan','a.NilaiPerolehan','a.kodeKelompok','a.AsalUsul','a.AsalUsul');

/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = "Aset_ID";

/* DB table to use */
$sTable = "aset as a";
$dataParam['id']=$_GET['id'];

$PENGGUNAAN = new RETRIEVE_PENGGUNAAN;
$PENGHAPUSAN = new RETRIEVE_PENGHAPUSAN;

////pr($data);
//exit;
$sLimit = "";
if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
     $sLimit = " " . intval($_GET['iDisplayStart']) . ", " .
             intval($_GET['iDisplayLength']);
}


/*
 * Ordering
 */
$sOrder = "";
if (isset($_GET['iSortCol_0'])) {
     $sOrder = "ORDER BY  ";
     for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
          if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
               //$sOrder .= "'" . $aColumns[intval($_GET['iSortCol_' . $i])] . "' " .
               $sOrder .= "" . $aColumns[intval($_GET['iSortCol_' . $i])] . " " .
                       ($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
          }
     }

     $sOrder = substr_replace($sOrder, "", -2);
     if ($sOrder == "ORDER BY") {
          $sOrder = "ORDER BY a.kodeKelompok,a.noRegister,a.Tahun";
     }
}


/*
 * Filtering
 * NOTE this does not match the built-in DataTables filtering which does it
 * word by word on any field. It's possible to do here, but concerned about efficiency
 * on very large tables, and MySQL's regex functionality is very limited
 */
//$sWhere = "";
if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
     //$sWhere = "WHERE (";
     $sWhere ="(";
     for ($i = 0; $i < count($aColumns); $i++) {
          if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true") {
               $sWhere .= "" . $aColumns[$i] . " LIKE '%" . mysql_real_escape_string($_GET['sSearch']) . "%' OR ";
          }
     }
     $sWhere = substr_replace($sWhere, "", -3);
     $sWhere .= ')';
}

/* Individual column filtering */
for ($i = 0; $i < count($aColumns); $i++) {
     if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
          if ($sWhere == "") {
        //       $sWhere = "WHERE ";
               $tidakdipakai=0;
          } else {
               $sWhere .= " AND ";
          }
          $sWhere .= "`" . $aColumns[$i] . "` LIKE '%" . mysql_real_escape_string($_GET['sSearch_' . $i]) . "%' ";
     }
}


/*
 * SQL queries
 * Get data to display
 */

$dataParam['condition']="$sWhere ";
$dataParam['order']=$sOrder;  
$dataParam['limit']="$sLimit";
//pr($dataParam);
$dataSESSION = $PENGGUNAAN->retrieve_daftar_usulan_aset_penggunaan($dataParam); 
//pr($dataSESSION);
//$rResult = $DBVAR->query($sQuery);

// /* Data set length after filtering */
$sQuery = "
		SELECT FOUND_ROWS()
	";
$rResultFilterTotal = $DBVAR->query($sQuery);
$aResultFilterTotal = $DBVAR->fetch_array($rResultFilterTotal);
$iFilteredTotal = $aResultFilterTotal[0];

//echo $iFilteredTotal ;

/* Total data set length */
$sQuery = "
		SELECT COUNT(p.Penggunaan_ID)
		FROM   penggunaan as  p INNER JOIN penggunaanaset as pa 
    ON p.Penggunaan_ID = pa.Penggunaan_ID WHERE p.Penggunaan_ID = '{$dataParam['id']}'";

//echo "$sQuery";
$rResultTotal = $DBVAR->query($sQuery);
$aResultTotal = $DBVAR->fetch_array($rResultTotal);
//pr($aResultTotal );
$iTotal = $aResultTotal[0];


/*
 * Output
 */
$output = array(
    "sEcho" => intval($_GET['sEcho']),
    "iTotalRecords" => $iTotal,
    "iTotalDisplayRecords" => $iFilteredTotal,
    "aaData" => array()
);

$data_post=$PENGHAPUSAN->apl_userasetlistHPS("DELUSPNG");
//pr($data_post);
$POST=$PENGHAPUSAN->apl_userasetlistHPS_filter($data_post);
//pr($POST);
//exit;
//$POST['penghapusanfilter']=$POST;
if($POST && $dataSESSION){
      foreach ($dataSESSION as $keySESSION => $valueSESSION) {
        if(!in_array($valueSESSION['Aset_ID'], $POST)){
          // echo "stringnot";
          $data[]=$valueSESSION;
          $data[$keySESSION]['checked']="";
        }else{

          $data[]=$valueSESSION;
          $data[$keySESSION]['checked']="checked";
        }
      }
    
  }else{
    $data=$dataSESSION; 
  }
 //pr($data);
 //exit; 
$no=$_GET['iDisplayStart']+1;
  if (!empty($data))
					{
foreach ($data as $key => $value)
						{
              //pr($value);
							
              $NamaSatker = $PENGHAPUSAN->getNamaSatker($value[kodeSatker]);
              //pr($NamaSatker);
              //exit;
              $tmp = explode('.', $value['kodeKelompok']);
              if($tmp[0] == '01'){
                $TipeAset = 'A';
              }elseif($tmp[0] == '02'){
                $TipeAset = 'B';
              }elseif($tmp[0] == '03'){
                $TipeAset = 'C';
              }elseif($tmp[0] == '04'){
                $TipeAset = 'D';
              }elseif($tmp[0] == '05'){
                $TipeAset = 'E';
              }elseif($tmp[0] == '06'){
                $TipeAset = 'F';
              }
              $SelectKIB=$PENGHAPUSAN->SelectKIB($value[Aset_ID],$TipeAset);
              //pr($SelectKIB);
							//exit;
              if($value[kondisi]==2){
								$kondisi="Rusak Ringan";
							}elseif($value[kondisi]==3){
								$kondisi="Rusak Berat";
							}elseif($value[kondisi]==1){
								$kondisi="Baik";
							}
							// //pr($value[TglPerolehan]);
							$TglPerolehanTmp=explode("-", $value[TglPerolehan]);
							// //pr($TglPerolehanTmp);
							$TglPerolehan=$TglPerolehanTmp[2]."/".$TglPerolehanTmp[1]."/".$TglPerolehanTmp[0];
       
                
              if($value['Status']==0){              
                 $checkbox="<input type=\"checkbox\" id=\"checkbox\" class=\"icheck-input checkbox\" onchange=\"return AreAnyCheckboxesChecked();\" name=\"penghapusan_nama_aset[]\" value=\"{$value['Aset_ID']}\" {$value['checked']}>";
                }else{
                  $checkbox="&nbsp;";
                }
         
                 $row = array();
                

                 $row[]=$no;
                 $row[]=$checkbox;
                 $row[]="<center>".$value['noRegister']."</center>";
                 $row[]="{$value['kodeKelompok']}<br/>{$value['Uraian']}";
                 $row[]="[".$value['kodeSatker'] ."]<br/>". $NamaSatker['0']['NamaSatker'];
                 $row[]="<center>".$TglPerolehan."</center>";
                 $row[]= number_format($value['NilaiPerolehan'],2,",",".");
                 $row[]=$kondisi. ' - ' .$value['AsalUsul'];
                 $row[]="{$SelectKIB[0][Merk]}-{$SelectKIB[0][Model]}";
                 
                 $output['aaData'][] = $row;
                  $no++;
                    }
              }
echo json_encode($output);

?>

