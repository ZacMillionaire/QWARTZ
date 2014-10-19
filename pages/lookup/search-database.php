<?php

$Data = $System->GetDataCollectionSystem();
$Search = $System->GetSearchSystem();

$searchResults = $Search->GeneralSearch($_POST);

print_r($searchResults);

?>

<div id="table-container">
	<form action="lookup.php?a=search" method="POST">
	<table>
		<tr>
			<th class="table-title" colspan="4">
				Player Search
			</th>
		</tr>
		<tr>
			<td>
				<input style="width: 100%" type="text" name="search" placeholder="Search" />
			</td>
		</tr>
	</table>
	<button style="width: 100%" class="button" type="submit">Search</button>
	</form>
</div>
<div id="search-results-container">

	<div class="search-results-table">
		<?php 
			if(!$searchResults){
		?>
		<div class="search-error">
			<h2>No data was found matching your query.</h2>
		</div>
		<?php
			} else {
		?>
		<?php
			foreach($searchResults as $key => $value) {
		?>
		<table>
			<tr>
				<th colspan="5" class="table-title"><?php echo $key; ?> Results</th>
			</tr>
			<?php foreach($value as $skey => $svalue){ ?>
			<tr>
				<td style="text-align:center;">
					<?php 
					
						switch ($key) {
							case 'Player':
								$link = "players.php?a=view&id=".$svalue["ID"];
								break;
							case 'Template':
								$link = "templates.php?a=view&id=".$svalue["ID"];
								break;
						}
						
					?>
					<a href="<?php echo $link; ?>"><?php echo $svalue["result"]; ?></a>
				</td>
			</tr>
			<?php } ?>
		</table>
		<?php
			}
		?>
		<?php
			}
		?>
	</div>
	
</div>

<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function(event) {
	$(".date-picker").datepicker();
});
</script>