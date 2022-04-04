<template>
 	<div class="graph-content">
		<div class="btn graph-open" v-on:click="open">{{ is_vote == 0 ? (is_open ? '非表示' : 'グラフを見る') : (is_open ? '非表示' : '投票') }}</div>

		<div class="vote-group" v-show="is_open">
			<canvas v-show="is_vote == 0"></canvas>
			<div 
				class="vote" v-for="(vote_item, index) in vote_items" :key=index 
				v-show="is_vote == 1"
				v-on:click="vote( vote_item.vote_id )"
			>
				{{ vote_item.vote_name }}
			</div>
		</div>
	</div>
</template>

<script>
export default {
	data() {
        return{
            is_open: false,
			open_count: 0,
			vote_items: {},
        }
    },
	props: ['theme_id', 'auth_id', 'is_vote'],
	methods: {
		open: function () {
			var canvas = $('canvas');

			if( this.open_count == 0 ){
				$('body').css('cursor', 'progress');
				$('body').css('pointer-events', 'none');

				//グラフの表示
				if( this.is_vote == 0 ){
					axios
					.get('mypage/themes/graph/'+this.theme_id, {})
					.then(response => {
						graph(response, canvas);
					})
					.catch(error => {
						alert('情報の取得に失敗しました。');
						$('body').css('cursor', 'default');
						$('body').css('pointer-events', 'auto');
						return false;
					});
				//投票項目の表示
				}else{
					axios
					.get('mypage/themes/vote-item/'+this.theme_id, {})
					.then(response => {
						this.vote_items = response.data
					})
					.catch(error => {
						alert('情報の取得に失敗しました。');
						$('body').css('cursor', 'default');
						$('body').css('pointer-events', 'auto');
						return false;
					});
				}
				$('body').css('cursor', 'default');
				$('body').css('pointer-events', 'auto');
			}
			this.is_open = !this.is_open;
			this.open_count++;
		},
		vote: function( vote_id ) {
			var canvas = $('canvas');

			axios
			.get('mypage/themes/vote/'+vote_id, {})
			.then(response => {
				this.is_vote = 0;
				graph(response, canvas);
			})
			.catch(error => {
				alert('情報の取得に失敗しました。');
				$('body').css('cursor', 'default');
				$('body').css('pointer-events', 'auto');
				return false;
			});
		}
	}
}

//グラフの作成
function graph(response, canvas) {
	var options = {
		scales: {
			yAxes : [{
				ticks : {
					max : 1,    
					min : 0
				}
			}],
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

	return true;
}
</script>