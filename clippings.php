<?php

if (!isset($_GET["clear"])) {
//} //fin clear	
// preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
?>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="css/clippy-css.css" type="text/css" media="screen, print" />
<title>Clipper: Liberate your Kindle notes and highlights.</title>
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js' type='text/javascript' ></script>
<script type='text/javascript' >
function showall()
	{
	// alert("aquí");
	var vindexlist = "<a name='index' /><H3>Índice</H3>";
	$( "div" ).each(function() {
		// console.log( "Index: " + $( this ).text() );
		// var vurl = "";
		if ( $(this).attr("inurl") !== undefined ) {
			var vurl = $(this).attr('inurl');
			var vid = $(this).attr('id');
			var vtitle = $(this).attr('titlechar');		
			vindexlist=vindexlist+"<li><a href='#"+vid+"'>"+vtitle+"</a></li>";
			
			// alert(vurl);
			$.get( (vurl+"&clear"), function(data) {
				$("div#"+vid).html("<a name='"+vid+"' />"+data+"<hr />");
				});
			}
	
	 	 
	 // if (vurl.indexOf("pub")>=0) {
		// alert( vid+" - "+vurl );
		// // $("div#"+vid).html('test');
			
		// // alert(vurl.indexOf("pub")+" - "+vurl);
		
		// // $.get(vurl+"&clear", function(data) {
			// // alert(data)
			// // // $("div#"+vurl).html("");
			// // alert( $(this).text() )
		// // });
		
		// }
	});
	// alert( vindexlist );
	// pubcontent
	$("div#indexlist").html( vindexlist );
	var vpubcontent=$("div#pubcontent").html();
	// $("div#pubsection").html("");
	$("div#pubsection").html("<p align='right'>[<a href='#index'>Índice</a>]</p>"+vpubcontent);
	// $("div#preindex").html("[<a href='#index'>Índice</a>]");
	// $("div#posindex").html("");
	
	}

</script>
</head>
<body bgcolor=#444444>

<div id="outer">
	<div id="pagetop">
		<div id="topleft">
		</div>
		<div id="topright">
		</div>
	</div>

<div id="paper">
	<div id="content">
	
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

 } //fin clear	

// echo "....1...".strtotime("10 September 2000"), "\n";
// echo "....2...".strtotime("13 diciembre 2015"), "\n";


 $debug=true; 
 
 $visnote=False;
//Poner notas
//parsing en español e inglés...
//adecuar plantillas de http://www.claybavor.com/clipper/books.php?id=lddtp8fbi9hkcmv2xgum
// http://www.claybavor.com/clipper/all.php?print=yes&id=lddtp8fbi9hkcmv2xgum
// http://www.claybavor.com/clipper/all.php?id=lddtp8fbi9hkcmv2xgum

// La alegría de la vida (Mingyur Rimponche, Yongey)
	$value=0;
	$vmode="aut";
	$vshowall=false;
	
	$vaut=(isset($_GET["aut"]))? urldecode($_GET["aut"]) :"";
	$vpub=(isset($_GET["pub"]))? urldecode($_GET["pub"]) :"";
	
	
	if (isset($_GET["aut"]) and isset($_GET["pub"])) {
		if ( ($_GET["aut"]=="") and ($_GET["pub"]=="") ) {
			$vmode="aut";	
			}
		else {
			$vmode="clip";		
			}		
		} else if (isset($_GET["aut"])) {
			$vmode="pub";
		}
			
	if (isset($_GET["toebookclip"])) {
		$vmode="aut";
		}
		
	if (isset($_GET["all"])) {
		$vmode="pub";
		$vshowall=true;
		}		
		
	$vsorttype="Date";
	if (isset($_GET["sort"])) {
		$vsorttype=$_GET["sort"];
		$vmode="pub";
		$vshowall=true;	
		$_GET["aut"]="";
		$_GET["pub"]="";
		}	
		
	$vtoviewall=false;
	if (isset($_GET["toviewall"])) {
		if ($_GET["toviewall"]!="") {
			$vtoviewall=true;
			$vmode=="clip";
			}		
		}
		
	if (isset($_GET["reset"])) {
		if ($_GET["reset"]=="1") {
			$vaut="";
			$vpub="";
			$vmode="pub";
			$vshowall=true;			
			}		
		}
	
		
$vprinton=True;	

$scan_dirclippings = scandir(".");

$vurlfollow=""; // $vurl



if (isset($_GET["userclip"])) {
	$dirclippings = $_GET["userclip"];	
	$vurlfollow="&userclip=".urlencode($dirclippings) ;
} else {
	$dirclippings = "My Clippings";	
	$vurlfollow="&userclip=".urlencode("My Clippings") ;
}

$scan_result = scandir($dirclippings);	
$vposline=0;

// 238
$month=array();
$month["enero"]='january';
$month["febrero"]='february';
$month["marzo"]='march';
$month["abril"]='april';
$month["mayo"]='may';
$month["junio"]='june';
$month["julio"]='july';
$month["agosto"]='august';
$month["septiembre"]='september';
$month["octubre"]='october';
$month["noviembre"]='november';
$month["diciembre"]='december';


if (!isset($_GET["clear"])) {

?>
<form name="formlib">
<input name='reset' type='hidden' value='0'/>
<select name='userclip' onchange='javascript:document.formlib.reset.value="1"; document.formlib.submit();'>
<?php
foreach ( $scan_dirclippings as $key => $value ) {
	$vselectedst="";
	if ($value==$dirclippings) {
		$vselectedst=" selected";
		}
	if ( (is_dir("$value") ) && (strpos(strtolower($value), 'clippings')>0) ) {
		echo"<option value='$value' $vselectedst>$value</option>";
		}
	}
?>
</select> » 

<select name='ebookclip' >
	<option value=''>All</option>
<?php
$_GET["ebookclip"]=(isset($_GET["ebookclip"]))? $_GET["ebookclip"] : "";

foreach ( $scan_result as $key => $value ) {
	if ( (is_file("$dirclippings/$value") ) && (strpos($value, '.txt')>0) ) {
		$vselected=($_GET["ebookclip"]==$value)?"selected":"";
		echo("<option value='$value' $vselected>$value</option>");
		}	
	}
	

if ( (isset($_GET["ebookclip"])) && ($_GET["ebookclip"]!="") ){ 
	 $scan_result=array("".$_GET["ebookclip"]);
	} 
echo"</select>";
// print_r($scan_result);
$vtabprint="PrintOn ";
$_GET["printon"]=(isset($_GET["printon"])) ? $_GET["printon"] : "1";
if (isset($_GET["toprinton"])) {
	$_GET["printon"]=($_GET["printon"]==1) ? "0": "1";
	}
echo"<input name='toebookclip' type='submit' value='»»'/>";
echo"<input name='aut' type='hidden' value='".urldecode($vaut)."'/>";
echo"<input name='pub' type='hidden' value='".urldecode($vpub)."'/>";
echo"<input name='printon' type='hidden' value='".$_GET["printon"]."'/>";

if ($_GET["printon"]=="1") {
	$vtabprint="PrintOn";
	$vprinton=True;
	} else {
	$vtabprint="PrintOff";	
	$vprinton=False;
	}

$voptional="";
if ($vmode!="clip") {
	$voptional="<input name='toviewall' type='button' value='Ver todo' onclick='javascript:showall();' /> |";	
	}
$vprintopt="";
if ($vmode=="clip") {
	$vprintopt="<input name='toprinton' type='submit' value='$vtabprint'/> |";	
	}
echo" [Ordenar: <input name='sort' type='submit' value='Nombre'/> | <input name='sort' type='submit' value='Cantidad'/> | <input name='sort' type='submit' value='Fecha'/> ] | $voptional $vprintopt <br/>[Filtro: <input name='f' type='text' value=''/>] [Permalink] ";
echo"<hr />";
echo"</form>";

	
echo("« <a href='?$vurlfollow'>Autores</a>/<a href='?all$vurlfollow'>Títulos</a> | <i>$vmode</i>: ");

if ($vmode=="clip") {
	echo("<a href='?aut=".urlencode($_GET["aut"])."$vurlfollow'>".$vaut."</a> »» <a href='?aut=".urlencode($vaut)."&pub=".urlencode($vpub)."$vurlfollow'>".$vpub."</a> <hr/>");
	
	}


} //fin clear	

$vlineFINNote="";
	
$vauthors=array();
$vdevices=array();
$vauthors_pubs=array();
$vauthors_urls=array();
$vdatereaded=array();
$vdatereadedstr=array();
$vclippingscount=array();	
$vclippings=array();	
$vpos=0;
$vclippos=0;
$vday="";
$vdaystr="";
	
	foreach ( $scan_result as $key => $value ) {

			if (is_file("$dirclippings/$value") )
				{
				// echo("$key > $value <br>");
				
				$vdevice=trim(str_replace(".txt","",$value));
				
				$handle = fopen("$dirclippings/$value", "r");
				
				if ($handle) {
					while (($line = fgets($handle)) !== false) {
						$line = trim($line);
						if (strpos($line, '====') !== false) {
							$vpos=0;
							} else {
							if ($line!="") {
								$vpos=$vpos+1;	
								if ($vpos==1) {
									$vobraname="";
									$vauthor="";
									
									//New clipping
									if (strpos($line, '(') !== false) {
									
										$split = explode("(", $line);
										
										if (count($split)>0) { //es una obra válida
										
											$vauthor=$split[count($split)-1];
											$vauthor=str_replace(")", "", $vauthor);
											
											$vauthor=trim(str_replace(";", " & ", $vauthor));
											$vauthor=trim(str_replace(" and ", " & ", $vauthor));
											$vauthor=trim(str_replace(" y ", " & ", $vauthor));	
											$vauthor=trim(str_replace(" De ", " de ", $vauthor));
											$vauthor=trim(str_replace("Escrito por", "", $vauthor));
											$vauthor=trim(str_replace("'", "`", $vauthor));	
											
											if ( (strpos($vauthor, ',') !== false) and (strpos($vauthor, '&') !== false) ) {
												$vauthor1=trim( substr($vauthor, 0, strpos($vauthor, '&')) );
												$vauthor2=trim( substr($vauthor, strpos($vauthor, '&')+1) );
												
												if (strpos($vauthor1, ',') !== false) {
													$v1=substr($vauthor1, 0, strpos($vauthor1, ','));
													$v2=substr($vauthor1, strpos($vauthor1, ',')+1);
													$vauthor1=trim($v2)." ".trim($v1);
													}
													
												if (strpos($vauthor2, ',') !== false) {
													$v1=substr($vauthor2, 0, strpos($vauthor2, ','));
													$v2=substr($vauthor2, strpos($vauthor2, ',')+1);
													$vauthor2=trim($v2)." ".trim($v1);
													}		
												$vauthor=$vauthor1." & ".$vauthor2;
												}
											
											if (strpos($vauthor, ',') !== false) {
												$v1=substr($vauthor, 0, strpos($vauthor, ','));
												$v2=substr($vauthor, strpos($vauthor, ',')+1);
												$vauthor=trim($v2)." ".trim($v1);
												// echo(" Arreglado: ".$vauthor);
												}
											
											if (!array_key_exists($vauthor, $vdevices)) {
												$vdevices[$vauthor] = $vdevice;	
												} else {
												if (stripos(" ".$vdevices[$vauthor], $vdevice) == false) {	
													$vdevices[$vauthor] = $vdevices[$vauthor].", ".$vdevice;		
													}
												}
											
											$vauthor=trim(str_replace(" ", " ", $vauthor));
																						
											$vobraname=trim(str_replace("($vauthor)", "", $line));
											
											// if (!array_key_exists($vobraname, $vdevices)) {
												// $vdevices[$vobraname] = $vdevice;	
												// } else {
												// if (strpos(" ".$vdevices[$vobraname], $vdevice) == false) {	
													// $vdevices[$vobraname] = $vdevices[$vobraname].", ".$vdevice;		
													// }
												// }
																						
											if ($vmode=="pub") {
												if (($vaut==$vauthor) or ($vshowall)) {
													
													// echo("<a href='?aut=$vauthor&pub=$vobraname'>$vobraname</a> ($value) <hr>");
													
													$vurl="?aut=".urlencode($vauthor)."&pub=".urlencode($vobraname);
													$vurl=str_replace("%EF", "", $vurl);
													$vurl=str_replace("%BB", "", $vurl);
													$vurl=str_replace("%BF", "", $vurl);
													
													$vauthors_urls[$vurl]=$vauthor;
													
													if (!array_key_exists($vurl, $vdevices)) {
														$vdevices[$vurl] = $vdevice;	
														} else {
														if (strpos(" ".$vdevices[$vurl], $vdevice) == false) {	
															$vdevices[$vurl] = $vdevices[$vurl].", ".$vdevice;		
															}
														}
													
													if (!array_key_exists($vurl, $vauthors_pubs)) {
														//primera obra
														$vauthors_pubs[$vurl] = 1;	
														$pubs[$vurl] = $vobraname;											
														} else {
														//Nueva obra
														$vauthors_pubs[$vurl] = $vauthors_pubs[$vurl]+1;	
														}
													}
												}
											else {
												if (!array_key_exists($line, $vclippingscount)) {
													//primera obra
													$vclippingscount[$line] = 1;						
													if (!array_key_exists($vauthor, $vauthors)) {
														$vauthors[$vauthor] = 1;	
														// echo "$vauthor >> $line <hr>";
														} else {
														$vauthors[$vauthor] = $vauthors[$vauthor]+1;	
														}							
													} else {
													//Nueva obra
													$vclippingscount[$line] = $vclippingscount[$line]+1;	
													}
												}
											
				
											} 
										}
										else {
											//Error en línea con contenido de obra+(autor)
										}
									
									
									} else {
										//Próximas líneas con subrayados, notas y contenidos....
										
										$vurl="?aut=".urlencode($vauthor)."&pub=".urlencode($vobraname);
										
										$match1=array();
										preg_match('/.*(\d+) de (enero|febrero|marzo|abril|mayo|junio|julio|agosto|septiembre|octubre|noviembre|diciembre) de (\d+).*/', $line, $match1); //22 de noviembre de 2015
										$vday="";
										if (isset($match1[3])) {
											$mes=$match1[2];
											$vday=($match1[1])." ".$month[$mes]." ".($match1[3]);
											// echo($line." >>> ".$vday." --- ".strtotime($vday));
									
											} else {
												preg_match('/.*(january|february|march|april|may|june|july|august|september|october|november|december) (\d+),(\d+).*/', strtolower($line), $match1); //November 18, 2010
												if (isset($match1[3])) {
													$mes=$match1[1];
													$vday=($match1[2])." ".$mes." ".($match1[3]);
													// echo($line." >>> ".$vday." --- ".strtotime($vday));
											
													}
											}
											
										if ($vday!="") {
											$vdaystr="($vday)";
											if ( array_key_exists($vurl, $vdatereaded) ) {
													if (intval($vdatereaded[$vurl])<intval(strtotime($vday))) {
														$vdatereaded[$vurl]=strtotime($vday);
														$vdatereadedstr[$vurl]=($vday);
														}
												} else {
													$vdatereaded[$vurl]=strtotime($vday);
													$vdatereadedstr[$vurl]=($vday);
												}
											} else {
											// if (strpos(url_decode($line),"diciembre")!== false ) {
											 // echo ("fecha: $line");
											 }
										}
										
										if ( ($vmode=="clip") ) {
											
											// $vhint=" title='".$vdevice."' ";
											$vhint=" title='$vdevice $vdaystr'";
										
											// 
											$vtemobraname="";
											$vtemvpub="";
											
											$vtemobraname=preg_replace('/[^A-Za-z0-9\-]/', '', $vobraname);
											$vtemvpub=preg_replace('/[^A-Za-z0-9\-]/', '', $vpub);
											
											
											if ( ( ( ($vtemobraname)== ($vtemvpub) ) and ( trim($vauthor)==trim($vaut) ) ) ) {

												// echo("<hr>$vobraname - $vauthor // $vpub - $vaut .... $line <br>");	
												// }
												
												// if ($vpos==2) {
													// // echo($_GET["aut"]." >>> ".$_GET["pub"]." >>> <hr/>");
													// // echo("<a href='?aut=".$_GET["aut"]."'>".$_GET["aut"]."</a> >>> <a href='?aut=".$_GET["aut"]."&pub=".$_GET["pub"]."'>".$_GET["pub"]."</a> <hr/>");
													// }
													
												
												//Posición de la cita
												preg_match('/.*(posición|Loc\.|Highlight on Page|Bookmark on Page) (\d+)/', $line, $match);
												// $vposline=0;
												$vclippos=$vclippos+1;
												if (isset($match[2])) {
													$vposline=$match[2];
													if (strpos($line, "on Page") > 0) {$vposline="$vposline-$vclippos";}
													// if (strpos($line, "on Page") > 0) {$vposline=$vclippos;}
													}	
												
												// if ($vposline==0) $vposline=99999+$vclippos;
																				
														
												if ($vprinton) {
													// echo("$line <br>");	
													if ( strpos(" ".$line, "●") !== false ) {
															$line=str_replace("●","<br/>●",$line);
															}													
													if ( (strpos($line, '-') == false) and (strpos($line, '|') == false) ) {
														
														$vlineprint=($visnote) ? "<span class=highlightnote>$line</span>" : "“".$line."”";
														$vlineprintextra=($visnote) ? "Nota, " : "";
														
														$vlineFIN="<span class=highlights $vhint >$vlineprint <span class=gray>($vlineprintextra$vposline)</span></span>";
														
														if ($visnote) {
															$vlineFINNote="<br>---» ".$vlineFIN;
															} else {
															
															$vclippings[$vurl][$vposline]=$vlineFIN.$vlineFINNote."<br><br>";
															// echo($vlineFIN.$vlineFINNote."<br><br>");
															$vlineFINNote="";
															}														
														}	
													else {
														
														$visnote=( (strpos($line, 'nota') !== false) or (strpos($line, 'Note') !== false) ); 
														$visBookmark=( (strpos($line, 'Bookmark') !== false) or (strpos($line, 'Marcador') !== false) ); 														
														if ($visBookmark) {

															$vclippings[$vurl][$vposline]="<span class=highlights><span class=highlightnote>Marcador </span><span class=gray>($vposline)</span></span><br><br>";
															// echo("<span class=highlights><span class=highlightnote>Marcador </span><span class=gray>($vposline)</span></span><br><br>");
															}
														}
													} else {
													if ( (strpos($line, '-') !== false) and (strpos($line, '|') !== false) ) {
														$vclippings[$vurl][$vclippos]="<hr/>";												
														// echo("<hr/>");
														$vclippos=$vclippos+1;
														}

													$vclippings[$vurl][$vclippos]="<span class=highlights $vhint >$line</span><br>";	
													// echo("$line <br>");	
													}
												
												}
											}
										
									}
									
								}
							}
							
					}
					fclose($handle);	
			}
			
		} 
	
	
	$cantlist=0; //Items printed...
	
	if ($vmode=="aut") {	
		
		echo("Authors »» <hr/>");		
		ksort($vauthors);
		echo("<ul>");
		foreach ($vauthors as $key => $value) {
			$vhint=""; 
			if (array_key_exists($key, $vdevices)) {
				$vhint=" title='".$vdevices[$key]."' ";
				}
			$key=str_replace('"', "", $key);
			$cantlist=$cantlist+1;
			echo("<li><a href='?aut=".urlencode($key).$vurlfollow."'$vhint>$key</a> ($value) </li>");
			}
		echo("</ul>");
		echo("<b>".$cantlist." encontrado(s).</b>");
		}
		

// Imprimir los clippings finales (contenido)	
// echo("<hr>fin<hr>");
	if ($vmode=="clip") {
		echo("<span class=bigtitle>".$vpub."</span> <br><span class=authorsub>by ".$_GET["aut"]."</span><br><br><br>");
		$vtemp=array();
		foreach ($vclippings as $key => $value) {
			$vtemp=$vclippings[$key];
			ksort($vtemp);
			foreach ($vtemp as $key1 => $value1) {
				echo("\r\n".$value1);
				}
			}
		// $vclippings[$vurl][$vposline]
		}
		
	if ($vmode=="pub") {	
		echo("<a href='?aut=".urlencode($vaut)."$vurlfollow' title='hover text' >".$vaut."</a> »» <hr/>");
		// ksort($vauthors_pubs);
		echo("<div id='pubsection'><ul><div id='pubcontent'>");
		
		
		$vauthors_pubs_pubssorted=array();		
		$vauthors_pubs_keysorted=array();
		

		foreach ($vauthors_pubs as $key => $value) {
			$sortname=$pubs[$key]; //title
			$vauthors_pubs_pubssorted[$sortname]=$key; //url
			$vauthors_pubs_keysorted[$sortname]=$value; //count
			}
			
		if ($vsorttype=="Nombre") {			
			ksort($vauthors_pubs_pubssorted);
			foreach ($vauthors_pubs_pubssorted as $key => $value) {
				$vhint=""; 
				if (array_key_exists($value, $vdevices)) {
					$vhint=" title='".$vdevices[$value]."' ";
					}
				$bookname = $key;
				$bookname=str_replace('"', "", $bookname);
				$bookname=str_replace("'", "`", $bookname);
				
				$author=$vauthors_urls[$value];
				$author=str_replace('"', "", $author);
				$author=str_replace("'", "`", $author);
				
				$authorlink=urlencode($author);
				// if ($vshowall) {
					// $bookname=$bookname." - <i>".$vauthors_urls[$value]."</i>";
					// }
					
				$value=str_replace('"', "", $value);
				$cantlist=$cantlist+1;
				echo("\r\n<div id='pub$cantlist' titlechar='$bookname - <i>$author</i>' inurl='$value$vurlfollow'><li><span class=titlelist><a href='".($value.$vurlfollow)."' $vhint>".($bookname)."</a></span><span class=authorlist> por <a href='?aut=$authorlink$vurlfollow'><i>$author</i></a> (".$vauthors_pubs_keysorted[$key].")</span> <a href='https://www.goodreads.com/search?utf8=✓&search_type=books&search%5Bfield%5D=on&q=$bookname+$author' target='_blank' rel='noopener noreferrer' ><img height='10px' src='googreads.jpg'/></a></li></div>");
				
				// <span class=titlelist><a href="highlights.php?title=7 lecciones errÃ³neas o falsos mitos que deberÃ­an eliminarse en las clases de ajedrez para niÃ±os&id=1mokm5lsnzhuf3ci6fx6">7 lecciones errÃ³neas o falsos mitos que deberÃ­an eliminarse en las clases de ajedrez para niÃ±os</a></span><span class=authorlist> by Escrito por LuÃ­s FernÃ¡ndez Siles</span>
				
				} 
			}
		else {			
			$temp_key_sorted=array();
			$temp_val_sorted=array();
			$temp_url_sorted=array();
			$temp_date_sorted=array();
			$tempsorted=array();
			$i=0;
			
			foreach ($vauthors_pubs_keysorted as $key => $value) {
				$i=$i+1;
				$temp_key_sorted[$i]=$key;
				$temp_val_sorted[$i]=$value;
				$temp_url_sorted[$i]=$vauthors_pubs_pubssorted[$key];	
				
				$vlastdatereaded=0;
				if (array_key_exists($key, $vdatereaded)) {
					$vlastdatereaded=$vdatereaded[$key];
					}
				$temp_date_sorted[$i]=$vlastdatereaded;
				}
				
			if ($vsorttype=="Cantidad") {
				$tempsorted=$temp_val_sorted;
				} else { //Last Date readed
				$tempsorted=$temp_date_sorted;	
				}
			
			
			for ($i = 1; $i <= count($tempsorted)-1; $i++) {
				for ($ii = $i+1; $ii <= count($tempsorted); $ii++) {
				if ( intval($tempsorted[$i]) > intval($tempsorted[$ii]) ) {
						$vtemp0=$tempsorted[$ii];
						$tempsorted[$ii]=$tempsorted[$i];
						$tempsorted[$i]=$vtemp0;					
						
					
						$vtemp0=$temp_val_sorted[$ii];
						$temp_val_sorted[$ii]=$temp_val_sorted[$i];
						$temp_val_sorted[$i]=$vtemp0;
						
						$vtemp0=$temp_key_sorted[$ii];
						$temp_key_sorted[$ii]=$temp_key_sorted[$i];
						$temp_key_sorted[$i]=$vtemp0;
						
						$vtemp0=$temp_url_sorted[$ii];
						$temp_url_sorted[$ii]=$temp_url_sorted[$i];
						$temp_url_sorted[$i]=$vtemp0;
						
						$vtemp0=$temp_date_sorted[$ii];
						$temp_date_sorted[$ii]=$temp_date_sorted[$i];
						$temp_date_sorted[$i]=$vtemp0;						
						}
					}
				}
				
			$vauthors_pubs_keysorted=array();
			for ($a = 1; $a <= count($temp_val_sorted); $a++) {
			// for ($i = count($temp_val_sorted); $i > 0; $i--) {
				if ($vsorttype=="Count") {
					$i=$a;
					} else {
					$i=	count($temp_val_sorted)-($a-1);
					}
				$vkey=$temp_key_sorted[$i];
				$count=$temp_val_sorted[$i];	
				$url=$temp_url_sorted[$i];	
				$value=$temp_url_sorted[$i];					
				$vauthors_pubs_keysorted[$vkey]=$value;
				
				$vlastreadstr="";
				$vlastdatereaded=0;
				if (array_key_exists($url, $vdatereaded)) {
					$vlastdatereaded=$vdatereaded[$url];
					$vlastreadstr=" (".$vdatereadedstr[$url].")";
					}
				
				
				$vhint=""; 
				if (array_key_exists($value, $vdevices)) {
					$vhint=" title='".$vdevices[$value].$vlastreadstr."' ";
					}
				
				$bookname = $vkey;
				$author=$vauthors_urls[$url];
				
				$bookname=str_replace('"', "", $bookname);
				$bookname=str_replace("'", "`", $bookname);
				
				$author=str_replace('"', "", $author);
				$author=str_replace("'", "`", $author);
				
				$authorlink=urlencode($author);
				
				// if ($vshowall) {
					// $bookname=$bookname." - <i>".$vauthors_urls[$url]."</i>";
					// }
					
				$url=str_replace('"', "", $url);
				$cantlist=$cantlist+1;
				// echo("<li><a href='".($url)."' $vhint>".($bookname)."</a> (".$count.") </li>");
				echo("\r\n<div id='details$a' titlechar='$bookname - <i>$author</i>' inurl='$url$vurlfollow'><li><span class=titlelist><a href='".($url.$vurlfollow)."' $vhint>".($bookname)."</a></span><span class=authorlist> por <a href='?aut=$authorlink$vurlfollow'><i>$author</i></a> (".$count.") <a href='https://www.goodreads.com/search?utf8=✓&search_type=books&search%5Bfield%5D=on&q=$bookname+$author'target='_blank' rel='noopener noreferrer' ><img height='10px' src='googreads.jpg'/></a></span></li></div>"); 
				
				}
			}
			
		

		
			
		// foreach ($vauthors_pubs as $key => $value) {
			// $vhint=""; 
			// if (array_key_exists($key, $vdevices)) {
				// $vhint=" title='".$vdevices[$key]."' ";
				// }
			// $key=str_replace('"', "", $key);
			// echo("<li><a href='".($key)."' $vhint>".($pubs[$key])."</a> ($value)</li>");
			// }
		
		echo("</div></ul></div>"); //pubcontent
		echo("<ul><div id='indexlist'></div></ul>");
		echo("<b>".$cantlist." encontrado(s).</b>");
		}				
		
if (isset($_GET["userclip"])) {		
	if ($_GET["userclip"]=="Temp Clippings") {
		?>
		<br/><hr/><br/>
		<form method="post" enctype="multipart/form-data">
			Seleccione el archivo "My Clippings.txt" de la carpeta "documents" del kindle: <input type="file" name="esource" size="25" /><br/>
			<input type="submit" name="submit" value="Subir archivo!!!" />
		</form>
		<?php
		if (isset($_FILES['esource']['name'])) {
		//if they DID upload a file...
				if($_FILES['esource']['name'])
				{
				 //if no errors...
				 if(!$_FILES['esource']['error'])
					 {
					 print_r($_FILES['esource']);
					 $fileName=$_FILES["esource"]["name"];
					 $fileName=str_replace(".txt","",$fileName).".txt";
					 $tmpFileName= $_FILES["esource"]["tmp_name"];
					 move_uploaded_file($tmpFileName,'Temp Clippings/'.$fileName);
					 }
				}
			}
		}
	}
	
if (!isset($_GET["clear"])) {

?>
</div>
</div>

	<div id="pagebottom">
		<div id="bottomleft">
		</div>	
		
		<div id="bottomright">
		</div>	
	</div>

</div>

<br><br><br>
<p>Design based in website <a href="http://www.claybavor.com/clipper"><i>http://www.claybavor.com/clipper</i></a>.</p>
<pre><?php if ($debug) { print_r($_GET); } ?></pre>

</body>
</html>
<?php
	} //fin clear	
?>