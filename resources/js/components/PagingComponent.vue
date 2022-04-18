<!-- ページング処理 -->
<template>
	<div class="add-item">
		<div v-show="is_loading" class="loading"><img src="/img/svg/preloader.svg"></div>
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
	props: ['is_mypage', 'search', 'sort', 'type_id'],
  	methods: {
		scroll() {
			var point = document.body.clientHeight - window.innerHeight;

			//スクロールの位置が最下部あたりになった場合 かつ 下スクロールをした場合
			if ( window.scrollY > point*0.9 && window.scrollY > this.startScrollPosition) {
				this.is_loading = true;
				var url = (this.is_mypage == 0 ? '/' : '/mypage')
					+'?search='+(this.search ? this.search : '')
					+'&sort='+(this.sort ? this.sort : '')
					+'&type_id='+(this.type_id ? this.type_id : '')
					+'&page='+this.page
				;
				axios
				.get(url, {})
				.then(response => {
					this.themes = response;
					this.page = this.page + 1;
				})
				.catch(error => {;

				});
				this.is_loading = false;
			}

			this.startScrollPosition = window.scrollY;
		},
	},
}

</script>