<!-- ページング処理 -->
<template>
	<div class="add-item">
		<div v-show="is_loading" class="loading">
			<img src="/img/svg/preloader.svg">
		</div>
		<div 
			class="item"
			v-for="(theme, index) in themes" :key=index
		>
			OK
		</div>
	</div>

</template>

<script>
export default {
	data() {
		return{
			themes: {},
			startScrollPosition: 0,
			page: 2,
			is_active: true,
			is_loading: false,
		}
	},
	created() {
		window.addEventListener('scroll', this.scroll);
	},
  	methods: {
		scroll() {
			var point = document.body.clientHeight - window.innerHeight;

			//スクロールの位置が最下部あたりになった場合 かつ 下スクロールをした場合
			if ( window.scrollY > point*0.9 && window.scrollY > this.startScrollPosition) {
				this.is_loading = true;
				this.themes = {name:"Mike", sex:"Male"};
			}

			this.startScrollPosition = window.scrollY;
		},
	},
}

</script>