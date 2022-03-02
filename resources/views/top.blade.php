@extends('layouts.app')

@section('content')
<div class="wrapper">
	<div class="content">
		<div class="item">
			<div class="name">テスト君</div>
			<div class="body">
				好きな色は？
			</div>
			<div class="graph-open">開く</div>
			<div class="graph">
				<canvas id="graph1"></canvas>
			</div>
		</div>
	</div>
</div>

<script>
	var data = {
		labels: ["ワンピース", "ドラゴンボール", "銀魂", "黒子のバスケ", "その他"],
		datasets: [
			{
				label: '投票数',
				hoverBackgroundColor: "rgba(255,99,132,0.3)",
				data: [25, 19, 30, 11, 13],
			}
		]
	};
	var canvas = document.getElementById('graph1');
	var chart = new Chart(canvas, {
		type: 'bar',  //グラフの種類
		data: data,  //表示するデータ
	});
</script>

@endsection