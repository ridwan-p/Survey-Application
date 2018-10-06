<template>
	<ul class="collection">
		<li class="collection-item jc-between">
			<h2 class="collection-title">Recent Surveys</h2>
			<button class="btn btn-primary" @click="onCreate">Create</button>
		</li>
		<li class="collection-item" v-for="data in surveys.data">
			<router-link :to="`/surveys/${data.id}`">{{data.title}}</router-link>
		</li>
	</ul>
</template>

<script>
	import service from "../../utils/request"

	export default {
		data() {
			return {
				surveys : []
			}
		},

		beforeRouteEnter(to, from, next) {
			service.get("/surveys")
				.then(res => {
					next(vm => vm.setData(res))
				})
		},

		beforeRouteUpdate(to, from, next) {
			service.get("/surveys")
				.then(res => {
					this.setData(res)
					next()
				})
		},

		methods : {
			setData(res) {
				this.surveys = res.data
			},

			onCreate() {
				this.$router.push(`/surveys/create`)
			}
		}
	}
</script>