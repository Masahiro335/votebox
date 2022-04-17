<template>
	<div>
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
		}
	},
	created() {
		window.addEventListener('scroll', this.scroll);
	},
  	methods: {
		scroll() {
			var bottomPoint = document.body.clientHeight - window.innerHeight;
			//スクロールの位置が最下部になった場合
			if (bottomPoint <= window.scrollY) {
				alert('OK');
			}
		},
	},
}

</script>