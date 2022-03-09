<template>
 	<div class="graph-content">
		<div class="btn graph-open" v-on:click="open">開く</div>
		<div class="graph">
			<canvas></canvas>
		</div>
	</div>
</template>

<script>
export default {
	methods: {
		open: function (e) {
			var data = {
				labels: ["ワンピース", "ドラゴンボール", "銀魂", "黒子のバスケ", "その他"],
				datasets: [
					{
						label: '投票数',
						hoverBackgroundColor: "rgba(255,99,132,0.3)",
						data: [25, 19, 30, 11, 13],
					}
				]
			}
			var canvas = e.currentTarget.nextElementSibling.firstElementChild;
			var chart = new Chart(canvas, {
				type: 'bar',  //グラフの種類
				data: data,  //表示するデータ
			});
		}
	}
}
</script>