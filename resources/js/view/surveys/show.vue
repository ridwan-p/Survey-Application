<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{modal.title}}</h3>
            <div class="d-flex flex-row jc-between ai-center">
                <div>
                    <router-link to="">Take</router-link> |
                    <router-link :to="`/surveys/${modal.id}/edit`">Edit</router-link> |
                    <router-link to="">Answers</router-link>
                </div>
                <div>
                    <button class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <h4 class="card-title">Question</h4>
            <div class="d-flex flex-column">

            </div>
            <h4 class="card-title">Add Question</h4>
            <div class="d-flex flex-column">
                <select v-model="questionAdd.type" class="form-control" @change="onChooseOption">
                    <option value="" disabled>Choose your option</option>
                    <option v-for="type in questionType">{{type}}</option>
                </select>
                <div class="form-group">
                    <label for="question">Question</label>
                    <input type="text" class="form-control" id="question" v-model="questionAdd.title" placeholder="Please Enter Your Question">
                </div>

                <div class="form-group" v-if="questionAdd.type == 'radio' || questionAdd.type == 'checkbox'">
                	<label for="">Options</label>
                	<div class="d-flex" v-for="(value, index) in options">
                		<input type="text" class="form-control" v-model="questionAdd.options[index]">
						<button class="btn btn-link" @click="onDeleteOption">X</button>
                	</div>

                	<button class="btn btn-link" @click="onAdd">Add Other</button>
                </div>
                <div>
                    <button class="btn btn-primary" @click="onSubmit">Submit</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import service from "../../utils/request"

export default {
    data: () => {
        return {
            modal: Object.create(null),
            form_type: "",
            questionType: ["text", "textarea", "checkbox", "radio"],
            questionAdd: {
                title : "",
                type : "",
                survey_id : "",
                options : [],
            },
            options: [""]
        }
    },

    beforeRouteEnter(to, from, next) {
        const id = to.params.id

        service.get(`/surveys/${id}`)
            .then(res => {
                next(vm => vm.setData(res))
            })
    },

    beforeRouteUpdate(to, from, next) {
        const id = to.params.id

        service.get(`/surveys/${id}`)
            .then(res => {
                this.setData(res)
                next()
            })
    },

    methods: {
        setData(res) {
            this.modal = Object.assign({}, res.data.data)
            this.questions = Object.assign({}, res.data.data.questions)

            this.questionAdd.survey_id = this.modal.id
        },

        onSubmit() {
            service.post(`questions`, this.questionAdd)
            	.then(res => {
            		if(res.data && res.data.event){
            			const add = this.questionAdd
            			this.questions = [ ...this.questions, add ]
            		}
            	})
        },

        onAdd() {
        	this.options = [...this.options, ""]
        },

        onDeleteOption() {
        	if(this.options.length > 1){
        		this.options.pop()
        	}
        },

        onChooseOption() {
        	if(this.questionAdd.type === "textarea" || this.questionAdd.type === "text"){
        		this.questionAdd.options = null
        	}
        }

    }
}

</script>
