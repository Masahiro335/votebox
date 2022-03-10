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
	methods: {
		open: function (e) {
			if( this.open_count == 0 ){
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
			this.is_open = !this.is_open;
			this.open_count++;
		}
	}
}
</script>