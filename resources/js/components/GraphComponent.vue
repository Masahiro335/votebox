<template>
 	<div class="graph-content">
		<div class="btn graph-open" v-on:click="open">{{ is_open ? '非表示' : '表示' }}</div>
		<div class="graph">
			<canvas v-show="is_open" width="400px" height="200px"></canvas>
		</div>
	</div>
</template>

<script>
export default {
	data() {
        return{
            is_open: false,
			open_count: 0,
        }
    },
	props: ['theme_id', 'auth_id'],
	methods: {
		open: function (e) {
			var canvas = e.currentTarget.nextElementSibling.firstElementChild;

			if( this.open_count == 0 ){
				$('body').css('cursor', 'progress');
				$('body').css('pointer-events', 'none');

				axios
				.get('/themes/graph/'+this.theme_id, {})
				.then(function(response) {
					var options = {
						scales: {
							yAxes : [{
								ticks : {
									max : 1,    
									min : 0
								}
							}]
						}
					};
					var chartData = {
						labels: response.data.vote_name,
						datasets: [{
							label: '投票数',
							hoverBackgroundColor: "rgba(255,99,132,0.3)",
							data: response.data.vote_coount,
						}]
					}
					var chart = new Chart(canvas, {
						type: 'bar',
						data: chartData,
						options: options,
					});
				})
				.catch(function (error) {
					alert('情報の取得に失敗しました。');
					$('body').css('cursor', 'default');
					$('body').css('pointer-events', 'auto');
					return false;
				});
				$('body').css('cursor', 'default');
				$('body').css('pointer-events', 'auto');
			}
			this.is_open = !this.is_open;
			this.open_count++;
		}
	}
}
</script>