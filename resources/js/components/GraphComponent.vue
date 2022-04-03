<template>
 	<div class="graph-content">
		<div class="btn graph-open" v-on:click="open">{{ is_open ? '非表示' : '表示' }}</div>
		<div class="graph" v-if="!is_vote">
			<canvas v-show="is_open" width="400px" height="200px"></canvas>
		</div>
		<div class="vote-group" v-if="is_vote">
			<div 
				class="vote" v-for="(vote, index) in votes" :key=index 
				v-show="is_open"
				v-on:click="vote( vote.vote_id )"
			>
				{{ vote.vote_name }}
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
			votes: {},
        }
    },
	props: ['theme_id', 'auth_id', 'is_vote'],
	methods: {
		open: function (e) {
			var canvas = e.currentTarget.nextElementSibling.firstElementChild;

			if( this.open_count == 0 ){
				$('body').css('cursor', 'progress');
				$('body').css('pointer-events', 'none');

				//グラフの表示
				if( this.is_vote == 0 ){
					axios
					.get('mypage/themes/graph/'+this.theme_id, {})
					.then(function(response) {
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
					.get('mypage/themes/vote-itme/'+this.theme_id, {})
					.then(response => {
						this.votes = response.data
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
		vote: function ( vote_id ) {
			alert();
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