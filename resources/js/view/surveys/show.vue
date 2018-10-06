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
            <!-- <div class="card" > -->
            	<div v-for="question in questions" class="p-1">
            		<div class="d-flex jc-between">
	            		<strong>{{question.title}}</strong>
	            		<router-link :to="`/questions/${question.id}`">Edit</router-link>
            		</div>

            		<input type="text" class="form-control" v-if="question.type === 'text' ">

            		<textarea class="form-control"cols="30" rows="10" v-if="question.type === 'textarea' "></textarea>

					<div v-if="question.type === 'radio' || question.type === 'checkbox' " >
						<div class="form-group" v-for="option in question.options">
							<input  :type="question.type" :name="question.id">
							<label for="">{{option}}</label>
						</div>
					</div>
            	</div>
            <!-- </div> -->
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
            options: [""],
            errors: Object.create(null),
            questions:[]
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
            this.questions = Object.assign([], this.modal.questions)

            this.questionAdd.survey_id = this.modal.id
        },

        onSubmit() {
            service.post(`questions`, this.questionAdd)
            	.then(res => {
            		if(res.data && res.data.event){
            			let add = this.questionAdd
            			add.id = res.data.id

            			this.questions = [ ...this.questions, add ]
            		}
            	})
            	.catch(err => {
            		console.log(err.response)
            		const response = err.response

            		if(response.status === 422){
            			const data = response.data
            			this.errors = data.errors
            		}
            	})
            // const add = this.questionAdd
            // this.questions.push(add)
        },

        onAdd() {
        	this.options = [...this.options, ""]
        },

        onDeleteOption() {
        	if(this.options.length > 1){
        		this.options.pop()
        		this.questionAdd.options.pop()
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
