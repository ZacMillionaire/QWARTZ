<?php

	$pageTitle = "Dashboard";

	ob_start();

	require "inc/header.php";

	if(!$userLoggedIn){
		header("Location: login.php");
		die();
	}

	$userData = $Users->GetUserProfile($Users->GetUserIDFromHash($_COOKIE["loginHash"]));
	$Data = $System->GetDataCollectionSystem();
	$historyTable = $Data->GetHistoryTable(15);

	ob_end_flush();

?>

	<div id="container">
		<header id="top-header">
			<!-- Layout Header Start -->
			<?php
				include "inc/layout/header.php";
			?>
			<!-- Layout Header End -->
		</header>
		<nav id="main-nav">
			<!-- Side Nav Start -->
			<?php
				include "inc/side_navigation.php";
				?>
			<!-- Side Nav End -->
		</nav>
		<div id="content">
			
			<article>
				<h1>Dashboard</h1>
			</article>

			<article class="graph-container">
				<div class="graph-header">
					<h3>Monthly Exercise Data</h3>
				</div>
<!--
	TODO: needs to moved to own location in style sheet
	container needs to be made to fit in
-->
<style>

.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

.line {
  fill: none;
  stroke-width: 1.5px;
}

.tooltip {   
  position: absolute;           
  text-align: left;           
  padding: 2px;             
  font: 12px sans-serif;        
  background: lightsteelblue;   
  border: 0px;      
  pointer-events: none;         
}
.tooltip > .tooltip-header {
	font-weight: bold;
}
.tooltip > .tooltip-row {
}
#monthlyGraphContainer {
	position: relative;
}
</style>

				<?php include "data/monthlyGraph.php"; ?>
			</article>
			<div id="dashboard-2">
				<article class="table-box">
					<table>
						<tr>
							<th colspan="3" class="table-title">Changelog</th>
						</tr>
						<tr>
							<th>Date</th><th>User</th><th>Action</th>
						</tr>
						<?php

						foreach($historyTable as $key => $value) {

						?>
						<tr>
							<td>
								<?php echo date("d/m/Y g:ia",strtotime($value["datePerformed"])); ?>
							</td>
							<td>
								<?php echo $value["actor"]; ?>
							</td>
							<td>
								<a href="<?php echo $value["actionURL"]; ?>">
									<?php echo $value["action"]; ?>
								</a>
							</td>
						</tr>
						<?php

						}

						?>
					</table>
				</article>


				<article id="currently-logged">
					<h2>Currently Online</h2>

					<ul>
					<?php
					$userList = $Users->GetLoggedInUserList();

					foreach ($userList as $key => $value) {
					echo "<li>$value[firstName] $value[lastName]</li>";
					}

					?>
					</ul>

				</article>
			</div>
		</div>
	</div>
<?php 

	include "inc/footer.php";

?>