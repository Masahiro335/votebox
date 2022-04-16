<template>
 	<div class="graph-content">
		<div class="btn graph-open" v-on:click="open">{{ is_vote == 0 ? (is_open ? '非表示' : 'グラフを見る') : (is_open ? '非表示' : '投票') }}</div>

		<div class="vote-group" v-show="is_open">
			<canvas :id="theme_id" v-show="is_vote == 0"></canvas>
			<div 
				class="vote" v-for="(vote_name, index) in vote_names" :key=index 
				v-show="is_vote == 1"
				v-on:click="vote( vote_name.vote_id )"
			>
				{{ vote_name.vote_name }}
			</div>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return{
			is_open: false,
			vote_names: {},
			open_count: 0,
		}
	},
	props: ['theme_id', 'auth_id', 'is_vote'],
	methods: {
		open: function () {
			var canvas = $('canvas#'+this.theme_id);

			$('body').css('cursor', 'progress');
			$('body').css('pointer-events', 'none');

			if(this.open_count == 0){
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
					.get('mypage/themes/vote-name/'+this.theme_id, {})
					.then(response => {
						this.vote_names = response.data
					})
					.catch(error => {
						alert('情報の取得に失敗しました。');
						$('body').css('cursor', 'default');
						$('body').css('pointer-events', 'auto');
						return false;
					});
				}
			}
			$('body').css('cursor', 'default');
			$('body').css('pointer-events', 'auto');

			this.is_open = !this.is_open;
			this.open_count++;
		},
		vote: function( vote_id ) {
			var canvas = $('canvas#'+this.theme_id);

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
					//投票の最大値
					max : response.data.coount_max == 0 ? 1 : response.data.coount_max,    
					min : 0
				}
			}],
		}
	};

	//グラフのデータを取得
	var dataset = [];
	response.data.vote_name.forEach(function(vote_name, key) {
		dataset[key] = {
			label: vote_name,	//ラベル名
			data: String(response.data.vote_coount[key]),	//投票数
			//グラフの色。投票したグラフは赤色
			backgroundColor: response.data.is_vote[key] == true ? 'rgba(244, 143, 177, 0.6)' : 'rgba(100, 181, 246, 0.6)' 
		};
	});

	var chart = new Chart(canvas, {
		type: 'bar',
		data: {
			labels: ['投票結果'],
			datasets: dataset,
		},
		options: options,
	});
}
</script>