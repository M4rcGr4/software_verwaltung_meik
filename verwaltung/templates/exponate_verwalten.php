<?php 
	if(session_status() === PHP_SESSION_NONE){
		session_start();
	}
	include '../inc/controller.php';

	$routing = $_SESSION['routing'] ?? 'show_all';

	if ($routing != 'show_all' && $routing != 'edit' && $routing != 'show_exp') {
		$routing='show_all';
	}
?>

<!DOCTYPE HTML>
<!--
	Editorial by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Exponate verwalten</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Main -->
					<div id="main">
						<div class="inner padding-0">


							<!-- Content -->
								<section>
									<header class="main">
										<h1>Verwaltung bestehender Exponate</h1>
										<?php
											if($_SESSION['status_msg'] !== "") {
												switch (($_SESSION['status_msg']) ) {
													case 'show_exp_web':
														echo "<h5>Das Exponat wurde für den Webauftritt vorgemerkt.</h5>";
														$_SESSION['status_msg'] = "";
														break;
													case 'notshow_exp_web':
														echo "<h5>Das Exponat wurde aus dem Webauftritt entfernt.</h5>";
														$_SESSION['status_msg'] = "";
														break;
													case 'del_exp_prepare':
														echo "<h5>Das Exponat wurde zum Löschen vorgemerkt.</h5>";
														$_SESSION['status_msg'] = "";
														break;
												}
											}
										?>
									</header>


									<hr class="major" />

									<!-- Elements -->
									<?php 
									 	if ($routing === 'show_all') {
									?>
										<div class="row gtr-200">
											<div class="col-12">
											<h4>Exponate</h4>
												<?php // Filtermaske 
												if ($_SESSION['exp_filter'] != "") {
													$filter_array=explode("|",$_SESSION['exp_filter']);
												} else {
													$filter_array=explode("|","|||||||||");
												}
												?>
												<form method="post" action="/verwaltung/inc/controller.php">
													<div style="display: flex;">
														<input type="text" name="exp_nr" value="<?php if ($filter_array[0] != "") echo $filter_array[0]; ?>" placeholder="Exp-Nr">
														<input type="text" name="exp_name" value="<?php if ($filter_array[1] != "") echo $filter_array[1]; ?>" placeholder="Titel">
														<input type="text" name="exp_besch" value="<?php if ($filter_array[2] != "") echo $filter_array[2]; ?>" placeholder="Beschreibung">
													</div>
													<div style="display: flex;">
													<input type="text" name="exp_hersteller" value="<?php if ($filter_array[3] != "") echo $filter_array[3]; ?>" placeholder="Hersteller">
														<select name="exp_jahr">
															<option value="0" <?php if ($filter_array[4] == "0") echo "selected"; ?>>alle Jahre anzeigen</option>
															<?php
																$daten = exp_jahre();
																foreach($daten as $data){																			
																	echo "<option value=". $data['Baujahr'] . "";
																	if ($filter_array[4] == $data['Baujahr']) echo " selected";
																	echo ">" . $data['Baujahr'] . "</option>";																
																}
															?>
														</select>
														<input type="text" name="exp_wert" value="<?php if ($filter_array[5] != "") echo $filter_array[5]; ?>" placeholder="Wert">
													</div>
													<div style="display: flex;">
														<input type="text" name="exp_material" value="<?php if ($filter_array[6] != "") echo $filter_array[6]; ?>" placeholder="Material">
														<select name="exp_kat">
															<option value="0" <?php if ($filter_array[7] == "0") echo "selected"; ?>>alle Kategorien anzeigen</option>
															<?php
																$daten = show_kategorien();
																foreach($daten as $data){																			
																	echo "<option value=". $data['Kat_ID'] . "";
																	if ($filter_array[7] == $data['Kat_ID']) echo " selected";
																	echo ">" . $data['Bezeichnung'] . "</option>";																
																}
															?>
														</select>
														<select name="exp_zust">
															<option value="0" <?php if ($filter_array[8] == "0") echo "selected"; ?>>alle Zustände anzeigen</option>
															<?php
																$daten = show_zustaende('nicht_geloescht');
																foreach($daten as $data){																			
																	echo "<option value=". $data['Zu_ID'] . "";
																	if ($filter_array[8] == $data['Zu_ID']) echo " selected";
																	echo ">" . $data['Bezeichnung'] . "</option>";																
																}
															?>
														</select>
														<select name="exp_stand">
															<option value="0" <?php if ($filter_array[9] == "0") echo "selected"; ?>>alle Standorte anzeigen</option>
															<?php
																$daten = show_standorte();
																foreach($daten as $data){																			
																	echo "<option value=". $data['Standort_ID'] . ""; 
																	if ($filter_array[9] == $data['Standort_ID']) echo " selected";
																	echo ">" . $data['Name'] . "</option>";																
																}
															?>
														</select>
													</div>
													<input type="submit" value="suchen">
													<input type="hidden" name="filter" value="1">
													<input type="hidden" name="routing" value="show_all">
												</form>
												<form method="post" action="/verwaltung/inc/controller.php">
													<input type="submit" value="Filter zurücksetzen">
													<input type="hidden" name="filter" value="-1">
													<input type="hidden" name="routing" value="show_all">
												</form>
											</div>
										</div>
										<div class="row gtr-200">
											<div class="col-12">
												<div class="table-wrapper">
													<table class="alt">
														<thead>
															<tr>
																<th>Exp.-Nr.
																	<form method="post" action="/verwaltung/inc/controller.php">
																		<a href="javascript:void(0);" onclick="parentNode.submit();" class="icon">
																			<?php if(str_contains($_SESSION['exp_sort'],"asc") && str_contains($_SESSION['exp_sort'],"1")) { ?>
																				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 11h12v2H3m0 5v-2h18v2M3 6h6v2H3Z"/></svg>
																			<?php } else { ?>
																				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 13h12v-2H3m0-5v2h18V6M3 18h6v-2H3z"/></svg>
																			<?php } ?>
																		</a>
																		<input type="hidden" name="routing" value="show_all">
																		<input type="hidden" name="sort" value="1">
																		<input type="hidden" name="orderby" value="<?php if(str_contains($_SESSION['exp_sort'],"desc") && str_contains($_SESSION['exp_sort'],"1")) { echo "asc"; } else { echo "desc"; } ?>">
																	</form>
																</th>
																<th>Name
																	<form method="post" action="/verwaltung/inc/controller.php">
																		<a href="javascript:void(0);" onclick="parentNode.submit();" class="icon">
																			<?php if(str_contains($_SESSION['exp_sort'],"asc") && str_contains($_SESSION['exp_sort'],"2")) { ?>
																				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 11h12v2H3m0 5v-2h18v2M3 6h6v2H3Z"/></svg>
																			<?php } else { ?>
																				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 13h12v-2H3m0-5v2h18V6M3 18h6v-2H3z"/></svg>
																			<?php } ?>
																		</a>
																		<input type="hidden" name="routing" value="show_all">
																		<input type="hidden" name="sort" value="2">
																		<input type="hidden" name="orderby" value="<?php if(str_contains($_SESSION['exp_sort'],"desc") && str_contains($_SESSION['exp_sort'],"2")) { echo "asc"; } else { echo "desc"; } ?>">
																	</form>
																</th>
																<th>Beschreibung
																	<form method="post" action="/verwaltung/inc/controller.php">
																		<a href="javascript:void(0);" onclick="parentNode.submit();" class="icon">
																			<?php if(str_contains($_SESSION['exp_sort'],"asc") && str_contains($_SESSION['exp_sort'],"3")) { ?>
																				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 11h12v2H3m0 5v-2h18v2M3 6h6v2H3Z"/></svg>
																			<?php } else { ?>
																				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 13h12v-2H3m0-5v2h18V6M3 18h6v-2H3z"/></svg>
																			<?php } ?>
																		</a>
																		<input type="hidden" name="routing" value="show_all">
																		<input type="hidden" name="sort" value="3">
																		<input type="hidden" name="orderby" value="<?php if(str_contains($_SESSION['exp_sort'],"desc") && str_contains($_SESSION['exp_sort'],"3")) { echo "asc"; } else { echo "desc"; } ?>">
																	</form>
																</th>
																<th>Hersteller
																	<form method="post" action="/verwaltung/inc/controller.php">
																		<a href="javascript:void(0);" onclick="parentNode.submit();" class="icon">
																			<?php if(str_contains($_SESSION['exp_sort'],"asc") && str_contains($_SESSION['exp_sort'],"4")) { ?>
																				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 11h12v2H3m0 5v-2h18v2M3 6h6v2H3Z"/></svg>
																			<?php } else { ?>
																				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 13h12v-2H3m0-5v2h18V6M3 18h6v-2H3z"/></svg>
																			<?php } ?>
																		</a>
																		<input type="hidden" name="routing" value="show_all">
																		<input type="hidden" name="sort" value="4">
																		<input type="hidden" name="orderby" value="<?php if(str_contains($_SESSION['exp_sort'],"desc") && str_contains($_SESSION['exp_sort'],"4")) { echo "asc"; } else { echo "desc"; } ?>">
																	</form>
																</th>
																<th>Baujahr
																	<form method="post" action="/verwaltung/inc/controller.php">
																		<a href="javascript:void(0);" onclick="parentNode.submit();" class="icon">
																			<?php if(str_contains($_SESSION['exp_sort'],"asc") && str_contains($_SESSION['exp_sort'],"5")) { ?>
																				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 11h12v2H3m0 5v-2h18v2M3 6h6v2H3Z"/></svg>
																			<?php } else { ?>
																				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 13h12v-2H3m0-5v2h18V6M3 18h6v-2H3z"/></svg>
																			<?php } ?>
																		</a>
																		<input type="hidden" name="routing" value="show_all">
																		<input type="hidden" name="sort" value="5">
																		<input type="hidden" name="orderby" value="<?php if(str_contains($_SESSION['exp_sort'],"desc") && str_contains($_SESSION['exp_sort'],"5")) { echo "asc"; } else { echo "desc"; } ?>">
																	</form>
																</th>
																<th>Wert
																	<form method="post" action="/verwaltung/inc/controller.php">
																		<a href="javascript:void(0);" onclick="parentNode.submit();" class="icon">
																			<?php if(str_contains($_SESSION['exp_sort'],"asc") && str_contains($_SESSION['exp_sort'],"6")) { ?>
																				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 11h12v2H3m0 5v-2h18v2M3 6h6v2H3Z"/></svg>
																			<?php } else { ?>
																				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 13h12v-2H3m0-5v2h18V6M3 18h6v-2H3z"/></svg>
																			<?php } ?>
																		</a>
																		<input type="hidden" name="routing" value="show_all">
																		<input type="hidden" name="sort" value="6">
																		<input type="hidden" name="orderby" value="<?php if(str_contains($_SESSION['exp_sort'],"desc") && str_contains($_SESSION['exp_sort'],"6")) { echo "asc"; } else { echo "desc"; } ?>">
																	</form>
																</th>																
																<th>Material
																	<form method="post" action="/verwaltung/inc/controller.php">
																		<a href="javascript:void(0);" onclick="parentNode.submit();" class="icon">
																			<?php if(str_contains($_SESSION['exp_sort'],"asc") && str_contains($_SESSION['exp_sort'],"7")) { ?>
																				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 11h12v2H3m0 5v-2h18v2M3 6h6v2H3Z"/></svg>
																			<?php } else { ?>
																				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 13h12v-2H3m0-5v2h18V6M3 18h6v-2H3z"/></svg>
																			<?php } ?>
																		</a>
																		<input type="hidden" name="routing" value="show_all">
																		<input type="hidden" name="sort" value="7">
																		<input type="hidden" name="orderby" value="<?php if(str_contains($_SESSION['exp_sort'],"desc") && str_contains($_SESSION['exp_sort'],"7")) { echo "asc"; } else { echo "desc"; } ?>">
																	</form>
																</th>
																<th>Kategorie
																	<form method="post" action="/verwaltung/inc/controller.php">
																		<a href="javascript:void(0);" onclick="parentNode.submit();" class="icon">
																			<?php if(str_contains($_SESSION['exp_sort'],"asc") && str_contains($_SESSION['exp_sort'],"8")) { ?>
																				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 11h12v2H3m0 5v-2h18v2M3 6h6v2H3Z"/></svg>
																			<?php } else { ?>
																				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 13h12v-2H3m0-5v2h18V6M3 18h6v-2H3z"/></svg>
																			<?php } ?>
																		</a>
																		<input type="hidden" name="routing" value="show_all">
																		<input type="hidden" name="sort" value="8">
																		<input type="hidden" name="orderby" value="<?php if(str_contains($_SESSION['exp_sort'],"desc") && str_contains($_SESSION['exp_sort'],"8")) { echo "asc"; } else { echo "desc"; } ?>">
																	</form>
																</th>
																<th>Zustand
																	<form method="post" action="/verwaltung/inc/controller.php">
																		<a href="javascript:void(0);" onclick="parentNode.submit();" class="icon">
																			<?php if(str_contains($_SESSION['exp_sort'],"asc") && str_contains($_SESSION['exp_sort'],"9")) { ?>
																				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 11h12v2H3m0 5v-2h18v2M3 6h6v2H3Z"/></svg>
																			<?php } else { ?>
																				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 13h12v-2H3m0-5v2h18V6M3 18h6v-2H3z"/></svg>
																			<?php } ?>
																		</a>
																		<input type="hidden" name="routing" value="show_all">
																		<input type="hidden" name="sort" value="9">
																		<input type="hidden" name="orderby" value="<?php if(str_contains($_SESSION['exp_sort'],"desc") && str_contains($_SESSION['exp_sort'],"9")) { echo "asc"; } else { echo "desc"; } ?>">
																	</form>
																</th>
																<th>Standort
																	<form method="post" action="/verwaltung/inc/controller.php">
																		<a href="javascript:void(0);" onclick="parentNode.submit();" class="icon">
																			<?php if(str_contains($_SESSION['exp_sort'],"asc") && str_contains($_SESSION['exp_sort'],"10")) { ?>
																				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 11h12v2H3m0 5v-2h18v2M3 6h6v2H3Z"/></svg>
																			<?php } else { ?>
																				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 13h12v-2H3m0-5v2h18V6M3 18h6v-2H3z"/></svg>
																			<?php } ?>
																		</a>
																		<input type="hidden" name="routing" value="show_all">
																		<input type="hidden" name="sort" value="10">
																		<input type="hidden" name="orderby" value="<?php if(str_contains($_SESSION['exp_sort'],"desc") && str_contains($_SESSION['exp_sort'],"10")) { echo "asc"; } else { echo "desc"; } ?>">
																	</form>
																</th>
															</tr>
														</thead>
														<tbody>
															<?php																
																$daten = get_exponate($_SESSION['exp_filter'],$_SESSION['exp_sort']);																
																foreach($daten as $data){
																	echo "<tr>";
																	echo "<td>" . $data['Exp-Nr'];
																	if ($data['mark_web'] == 2) {echo "<br><span style='color: green;'>W</span>";}
																	echo "</td>";
																	echo "<td>" . $data['Titel'] . "</td>";
																	echo "<td>" . substr($data['Beschreibung'],0,30);
																	if (strlen($data['Beschreibung'])>30) {echo " [...]";}
																	echo "</td>";
																	echo "<td>" . $data['Hersteller'] . "</td>";
																	echo "<td>" . $data['Baujahr'] . "</td>";
																	echo "<td>" . $data['Wert'] . "</td>";																	
																	echo "<td>" . $data['Material'] . "</td>";
																	if ($data['Kategorie'] === "") {
																		echo "<td>(ohne Kategorie)</td>";
																	} else {
																		echo "<td>" . $data['Kategorie'] . "</td>";
																	}
																	echo "<td>" . $data['Zustand'] . "</td>";
																	if ($data['Standort'] === "") {
																		echo "<td>(ohne Standort)</td>";
																	} else {
																		echo "<td>" . $data['Standort'] . "</td>";
																	}																		
																	?>
																	<td>
																		<form method="post" action="/verwaltung/inc/controller.php">
																			<input type="hidden" name="exp_id" value="<?php  echo $data['Objekt_ID'] ?>">
																			<input type="hidden" name="routing" value="show_exp">
																			<input type="submit" name="aktion" value="i" class="submit-icon">
																		</form>
																	</td>
																	<?php
																	if($_SESSION['recht'] == "1" || $_SESSION['recht'] == "2"){
																	?>
																	<td>
																		<form method="post" action="/verwaltung/inc/controller.php">
																			<input type="hidden" name="exp_id" value="<?php  echo $data['Objekt_ID'] ?>">
																			<input type="hidden" name="routing" value="edit">
																			<input type="submit" name="aktion" value="" class="submit-icon">
																		</form>
																	</td>
																	<?php } ?>
																	<?php
																	if($_SESSION['recht'] == "2"){
																	?>
																	<td>
																		<form method="post" action="/verwaltung/inc/controller.php">
																			<input type="hidden" name="exp_id" value="<?php  echo $data['Objekt_ID'] ?>">
																			<input type="hidden" name="routing" value="show_all">
																			<input type="hidden" name="del_exp" value="true">
																			<input type="submit" name="aktion" value="" class="submit-icon">
																		</form>
																	</td>
																	<?php } ?>
																	<?php
																	echo "</tr>";
																}
															?>																
														</tbody>															
													</table>
												</div>									
											</div>
										</div>
									<?php
									} elseif ($routing === 'show_exp') {
										$daten = get_exponat($_SESSION['exp_id']);
										$data = $daten[0];
									?>
										<form method="post" action="/verwaltung/inc/controller.php">
											<input type="hidden" name="routing" value="show_all">
											<input type='submit' value='zurück' class='primary'/>
										</form>
										<?php
											if($_SESSION['recht'] > 0){
										?>
											<form method="post" action="/verwaltung/inc/controller.php">
												<input type="hidden" name="exp_id" value="<?php  echo $_SESSION['exp_id'] ?>">
												<input type="hidden" name="routing" value="edit">
												<input type="submit" name="aktion" value="Bearbeiten" class="submit-icon">
											</form>
										<?php } ?>										
										<div class="exponat">
												<?php if ($data['mark_web'] > 0) {
													echo "<div class='one border-right gray'><strong>";
														if ($data['mark_web'] == 1) {echo "In Freigabe für Webauftritt";}
														if ($data['mark_web'] == 2) {echo "Im Webauftritt enthalten";}
													echo "</strong></div>";
												}?>
												<div class="four gray">
													<div class="name">Exp-Nr.</div>
													<div class="value"><?php echo $data['Exp-Nr']; ?></div>
													<div class="name">Titel</div>
													<div class="value border-right"><?php echo $data['Titel']; ?></div>
												</div>
												<div class="four">
													<div class="name">Baujahr</div>
													<div class="value"><?php echo $data['Baujahr']; ?> </div>
													<div class="name">Hersteller</div>
													<div class="value border-right"><?php echo $data['Hersteller']; ?> </div>
												</div>
												<div class="four gray">
													<div class="name">Org. Preis</div>
													<div class="value"><?php echo $data['OrigPreis']; ?> </div>
													<div class="name">Wert</div>
													<div class="value border-right"><?php echo $data['Wert']; ?> </div>
												</div>
												<div class="four">
													<div class="name">Herkunft</div>
													<div class="value"><?php echo $data['Herkunft']; ?> </div>
													<div class="name">Maße</div>
													<div class="value border-right"><?php echo $data['Abmessungen']; ?></div>
												</div>
												<div class="four gray">
													<div class="name">Material</div>
													<div class="value"><?php echo $data['Material']; ?> </div>
													<div class="name">Zustand</div>
													<div class="value border-right">
														<select name="expZust" id="expZust" disabled>
															<?php
																$zustaende = show_zustaende('');
																if ($data['Zu_ID'] == 0) {echo "<option value='0' selected>- kein Zustand gewählt-</option>";}																	
																foreach($zustaende as $zustand){																			
																	echo "<option value=". $zustand['Zu_ID'] ;
																	if ($zustand['Zu_ID'] == $data['Zu_ID']) { echo " selected";}
																	echo ">" . $zustand['Bezeichnung'] . "</option>";																
																}
															?>
														</select>
													</div>
												</div>
												<div class="four">
													<div class="name">Kategorie</div>
													<div class="value">
														<select name="expKat" id="expKat" disabled>
															<?php
																$kat = show_kategorien();
																if ($data['Kat_ID'] == 0) {echo "<option value='0' selected>- keine Kategorie gewählt-</option>";}
																foreach($kat as $kategorie){																			
																	echo "<option value=". $kategorie['Kat_ID'];
																	if ($kategorie['Kat_ID'] == $data['Kat_ID']) {echo " selected";}
																	echo ">" . $kategorie['Bezeichnung'] . "</option>";																
																}
															?>
														</select>
													</div>
													<div class="name">Standort</div>
													<div class="value border-right">
														<select name="expStandort" id="expStandort" disabled>
															<?php
																$standorte = show_standorte();
																if ($data['Standort_ID'] == 0) {echo "<option value='0' selected>- kein Standort gewählt-</option>";}
																foreach($standorte as $std){																			
																	echo "<option value=". $std['Standort_ID'];
																	if ($std['Standort_ID'] == $data['Standort_ID']) {echo " selected";}
																	echo ">" . $std['Name'] . "</option>";																
																}
															?>
														</select>
													</div>
												</div>
												<div class="two gray">
													<div class="name">Veranstaltungen</div>
													<div class="name border-right">Notizen für Besucher</div>
												</div>
												<div class="two">
													<div class="value"><?php echo $data['Ausstellung']; ?></div>
													<div class="value border-right"><?php echo $data['Interesse']; ?></div>
												</div>
												<div class="two gray">
													<div class="name">zug. Dokumente</div>
													<div class="name border-right">zug. Exponate</div>
												</div>
												<div class="two">
													<div class="value"></div>
													<div class="value border-right"></div>
												</div>
												<div class="one border-right gray">ausführl. Beschreibung</div>
												<div class="one border-right"><p><?php echo $data['Beschreibung']; ?></p></div>
												<input type="hidden" name="exp_id" value="<?php echo $_SESSION['exp_id']; ?>">
											</div>
									<?php
									} elseif ($routing === 'edit') {
										$daten = get_exponat($_SESSION['exp_id']);
										$data = $daten[0];
										?>
										<div style="display: inline-flex;">
											<form method="post" action="/verwaltung/inc/controller.php">
												<input type="hidden" name="routing" value="show_all">
												<input type='submit' value='zurück' class='primary'/>
											</form>											
											<?php if ($data['mark_web'] != 1) { ?>
												<form method="post" action="/verwaltung/inc/controller.php">
													<input type="hidden" name="exp_id" value="<?php echo $_SESSION['exp_id']; ?>">
													<input type="hidden" name="show_exp_in_web" value="true">
													<input type='submit' <?php if ($data['mark_web'] == 2) { ?> style="background-color: red;" <?php } ?> value='Webauftritt' class='primary'/>
												</form>
											<?php }	?>
											<?php if ($data['mark_delete'] != 1 && $data['mark_web'] != 2) { ?>
												<form method="post" action="/verwaltung/inc/controller.php">
													<input type="hidden" name="exp_id" value="<?php echo $_SESSION['exp_id']; ?>">
													<input type="hidden" name="del_exp" value="true">
													<input type='submit' style="background-color: red;" value='Löschung beantragen' class='primary'/>
												</form>
											<?php }	?>
											<?php if ($data['mark_delete'] != 1) { ?>
												<form method="post" action="/verwaltung/inc/controller.php">
													<input type="hidden" name="exp_id" value="<?php echo $_SESSION['exp_id']; ?>">
													<input type="hidden" name="pdf_erzeugen" value="true">
													<input type="hidden" name="routing" value="<?php echo $routing; ?>">
													<input type='submit' value='PDF erzeugen' class='primary'/>
												</form>
											<?php }	?>
										</div>
										<form method="post" action="/verwaltung/inc/controller.php">
											<div class="exponat">
												<?php if ($data['mark_web'] > 0) {
													echo "<div class='one border-right gray'><strong>";
														if ($data['mark_web'] == 1) {echo "In Freigabe für Webauftritt";}
														if ($data['mark_web'] == 2) {echo "Im Webauftritt enthalten";}
													echo "</strong></div>";
												}?>
												<div class="four gray">
													<div class="name">Exp-Nr.</div>
													<div class="value"><input type="text" name="expName" value="<?php echo $data['Exp-Nr']; ?>"></div>
													<div class="name">Titel</div>
													<div class="value border-right"><input type="text" name="expTitel" value="<?php echo $data['Titel']; ?>"></div>
												</div>
												<div class="four">
													<div class="name">Baujahr</div>
													<div class="value"><input type="text" name="expBaujahr" value="<?php echo $data['Baujahr']; ?>"></div>
													<div class="name">Hersteller</div>
													<div class="value border-right"><input type="text" name="expHersteller" value="<?php echo $data['Hersteller']; ?>"></div>
												</div>
												<div class="four gray">
													<div class="name">Org. Preis</div>
													<div class="value"><input type="text" name="expOrgPreis" value="<?php echo $data['OrigPreis']; ?>"></div>
													<div class="name">Wert</div>
													<div class="value border-right"><input type="text" name="expWert" value="<?php echo $data['Wert']; ?>"></div>
												</div>
												<div class="four">
													<div class="name">Herkunft</div>
													<div class="value"><input type="text" name="expHerkunft" value="<?php echo $data['Herkunft']; ?>"></div>
													<div class="name">Maße</div>
													<div class="value border-right"><input type="text" name="expMaße" value="<?php echo $data['Abmessungen']; ?>"></div>
												</div>
												<div class="four gray">
													<div class="name">Material</div>
													<div class="value"><input type="text" name="expMaterial" value="<?php echo $data['Material']; ?>"></div>
													<div class="name">Zustand</div>
													<div class="value border-right">
														<select name="expZust" id="expZust">
															<option value="0">- Zustand wählen-</option>																	
															<?php
																$zustaende = show_zustaende('nicht_geloescht');
																foreach($zustaende as $zustand){																			
																	echo "<option value=". $zustand['Zu_ID'] ;
																	if ($zustand['Zu_ID'] == $data['Zu_ID']) { echo " selected";}
																	echo ">" . $zustand['Bezeichnung'] . "</option>";																
																}
															?>
														</select>
													</div>
												</div>
												<div class="four">
													<div class="name">Kategorie</div>
													<div class="value">
														<select name="expKat" id="expKat">
															<option value="0">- Kategorie wählen-</option>
															<?php
																$kat = show_kategorien();
																foreach($kat as $kategorie){																			
																	echo "<option value=". $kategorie['Kat_ID'];
																	if ($kategorie['Kat_ID'] == $data['Kat_ID']) {echo " selected";}
																	echo ">" . $kategorie['Bezeichnung'] . "</option>";																
																}
															?>
														</select>
													</div>
													<div class="name">Standort</div>
													<div class="value border-right">
														<select name="expStandort" id="expStandort">
															<option value="0" <?php if ($data['Standort_ID'] == 0) {echo "selected";}?>>- Standort wählen-</option>
															<?php
																$standorte = show_standorte();
																foreach($standorte as $std){																			
																	echo "<option value=". $std['Standort_ID'];
																	if ($std['Standort_ID'] == $data['Standort_ID']) {echo " selected";}
																	echo ">" . $std['Name'] . "</option>";																
																}
															?>
														</select>
													</div>
												</div>
												<div class="two gray">
													<div class="name">Veranstaltungen</div>
													<div class="name border-right">Notizen für Besucher</div>
												</div>
												<div class="two">
													<div class="value"><textarea name="expVeranst"><?php echo $data['Ausstellung']; ?></textarea></div>
													<div class="value border-right"><textarea name="expNote"><?php echo $data['Interesse']; ?></textarea></div>
												</div>
												<div class="two gray">
													<div class="name">zug. Dokumente</div>
													<div class="name border-right">zug. Exponate</div>
												</div>
												<div class="two">
													<div class="value"></div>
													<div class="value border-right"></div>
												</div>
												<div class="one border-right">ausführl. Beschreibung</div>
												<div class="one border-right gray"><textarea rows="6" name="expBesch" ><?php echo $data['Beschreibung']; ?></textarea></div>
												<input type="hidden" name="exp_id" value="<?php echo $_SESSION['exp_id']; ?>">
												<input type="hidden" value="edit" name="routing">
												<input type="hidden" value="true" name="edit_exponat">
												<div class="one border-right gray border-bottom"><input type="submit" value="Speichern" class="primary"/></div>
											</div>
										</form>
									<?php
									}
									?>

								</section>

						</div>
					</div>

				<!-- Sidebar -->
			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>