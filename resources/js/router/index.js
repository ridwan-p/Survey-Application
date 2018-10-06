import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
	mode : "history",
	routes : [
		{path : "/surveys", component: require("../view/surveys/index")},
		{path : "/surveys/create", component: require("../view/surveys/form")},
		{path : "/surveys/:id/edit", component: require("../view/surveys/form"), meta : { mode : "edit"}},
		{path : "/surveys/:id", component: require("../view/surveys/show")}
	]
})

export default router