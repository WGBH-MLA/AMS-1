<script>
	$(document).ready(function() {
		Highcharts.theme = {
			colors: [
				'#000000',
				'#7D7D7D',
			],
			chart: {
				plotBackgroundColor: 'whiteSmoke',
				plotShadow: false,
				shadow: false,
				pointBorderWidth: 0
			},
			xAxis: {
				gridLineWidth: 0,
				labels: {
					style: {
						color: '#060b10',
						fontSize: '15px'
					}
				}
			},
			yAxis: {
				lineWidth: 0,
				tickWidth: 0,
				labels: {
					style: {
						color: '#000000'
					}
				}
			},
			legend: {
				itemStyle: {
					font: 'Verdana, sans-serif',
					color: '#000000'
				},
				itemHoverStyle: {
					color: '#000000'
				},
				itemHiddenStyle: {
					color: '#000000'
				}
			},
			labels: {
				style: {
					color: '#000000'
				}
			}
		};

		var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
	});
	function takeScreenShot() {
		html2canvas(document.body, {
			onrendered: function(canvas) {
				var img = canvas.toDataURL("image/png");

				console.log(img);

			}
		});
	}

</script>

	

	<!--<div><button onclick="takeScreenShot();" class="btn">Take Screen Shot</button></div>-->
	<div class="asset-stats">
		<div class="span4" style="width: 31%;">
			<div class="assets-sum"><?php echo number_format($material_goal['total']); ?></div>
			<div class="assets-subdetail">hrs digitized</div>

		</div>
		<div class="span4" style="width: 31%;">
			<div class="assets-sum"><?php echo $percentage_hours . '%'; ?></div>
			<div class="assets-subdetail">of <?php echo 'of ' . $total_hours . ' hrs'; ?> </div>

		</div>
		<div class="span4" style="width: 31%;">
			<div class="assets-sum"><?php echo number_format($at_crawford); ?></div>
			<div class="assets-subdetail">hrs at Crawford</div>

		</div>
	</div>
	<div style="clear: both;"></div>
	<?php $this->load->view('dashboard/_region'); ?>

	<?php $this->load->view('dashboard/_tv_radio'); ?>
	<div class="clearfix"></div>
	<?php $this->load->view('dashboard/_formats'); ?>


