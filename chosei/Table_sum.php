
<table class="table table-striped table-bordered">

	<tr>
		<th>都合</th>
		<?php
		for( $i=0; $i<count($day_time); $i++ ){
			echo "<th>".$day_time[$i]["day_time"]."</th>";
		} ?>
	</tr>
	<tr>
		<td class="coltsugo">◯</td>
		<?php
		for( $i=0; $i<count($day_time); $i++ ){
			echo "<td>".$p_sum[$i]["◯"]."人</td>";
		}
		?>
	</tr>
	<tr>
		<td class="coltsugo">△</td>
		<?php
		for( $i=0; $i<count($day_time); $i++ ){
			echo "<td>".$p_sum[$i]["△"]."人</td>";
		}
		?>
	</tr>
	<tr>
		<td class="coltsugo">✕</td>
		<?php
		for( $i=0; $i<count($day_time); $i++ ){
			echo "<td>".$p_sum[$i]["✕"]."人</td>";
		}
		?>
	</tr>
</table>
