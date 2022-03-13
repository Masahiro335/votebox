<template>
 	<div class="graph-content">
		<div class="btn graph-open" v-on:click="open">{{ is_open ? '非表示' : '表示' }}</div>
		<div class="graph">
			<canvas v-show="is_open"></canvas>
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
	props: ['theme_id'],
	methods: {
		open: function (e) {
			var canvas = e.currentTarget.nextElementSibling.firstElementChild;

			if( this.open_count == 0 ){
				axios
				.get('/themes/graph/'+this.theme_id, {})
				.then(function(response) {
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
					});
				})
				.catch(function (error) {
					alert('情報の取得に失敗しました。');
					return false;
				});
			}
			this.is_open = !this.is_open;
			this.open_count++;
		}
	}
}
</script>