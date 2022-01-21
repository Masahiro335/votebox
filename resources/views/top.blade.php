@extends('layouts.app')

@section('content')
<div class="wrapper">
    <div class="content">
        <div class="item">
            <div class="name">テスト君</div>
            <div class="body">
                好きな色は？
            </div>
			<div class="graph">
				<canvas id="stage1"></canvas>
				<script>
					var data = {
						labels: ["赤", "青", "白", "黒", "その他"],
						datasets: [
							{
								label: '投票数',
								hoverBackgroundColor: "rgba(255,99,132,0.3)",
								data: [65, 59, 80, 81, 56],
							}
						]
					};
					var canvas = document.getElementById('stage1');
					var chart = new Chart(canvas, {
						type: 'bar',  //グラフの種類
						data: data,  //表示するデータ
					});
				</script>
			</div>
        </div>
        <div class="item">
            <div class="name">テスト君</div>
            <div class="body">
                好きなアニメは？
            </div>
			<div class="graph">
				<canvas id="stage2"></canvas>
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
					var canvas = document.getElementById('stage2');
					var chart = new Chart(canvas, {
						type: 'bar',  //グラフの種類
						data: data,  //表示するデータ
					});
				</script>
			</div>
        </div>
    </div>
</div>

@endsection