<template>
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">{{title}} Survey</h3>
		</div>
		<div class="card-body d-flex flex-column">
			<div class="form">
				<label for="title">Title <input type="text" class="form-control" v-model="form.title" id="title"></label>
				<label for="description">Description <textarea v-model="form.description" id="description" cols="30" rows="10" class="form-control"></textarea></label>
			</div>
			<div style="align-self:flex-end">
				<button class="btn btn-primary" @click="onSave">Save</button>
			</div>

		</div>
	</div>
</template>

<script>
	import service from "../../utils/request"

	export default {
		data : () => {
			return {
				form: Object.create(null),
				title: "Create",
				method: "POST",
				action: "/surveys/",
				errors: Object.create(null),
			}
		},

		beforeRouteEnter(to, from, next) {
			if(to.meta.mode === "edit"){
				const id = to.params.id
				service.get(`/surveys/${id}`)
					.then(res => {
						next(vm => vm.setData(res))
					})
			} else {
				next()
			}
		},

		beforeRouteUpdate(to, from, next) {
			if(to.meta.mode === "edit"){
				const id = to.params.id
				service.get(`/surveys/${id}`)
					.then(res => {
						this.setData(res)
						next()
					})
			} else {
				next()
			}
		},

		methods: {
			setData(res){
				const id = this.$route.params.id

				this.form = Object.assign({}, res.data.data)
				this.title = "Edit"
				this.method = "PUT"
				this.action = `/surveys/${id}`
			},

			onSave(){
				const send = {
					method : this.method,
					url : this.action,
					data: this.form
				}
				service(send)
					.then(res => {
						if(res.data && Object.is(res.data.event, true)) {
							this.success(res)
						}
					})
					.catch(err => {
						if(error.response.status === 422){
							this.errors = error.response.data.errors
						}
					})
			},

			success(res) {
				this.$router.push(`/surveys/${res.data.id}`)
			}

		}
	}
</script>