<template>
	<div class="add-item">
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
				this.themes = {name:"Mike", sex:"Male"};
			}

			this.startScrollPosition = window.scrollY;
		},
	},
}

</script>