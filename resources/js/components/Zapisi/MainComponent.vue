<template>
<div class="box_selector">  
<select v-model="currentStream" @change="changeCurrentStream()">
    <template v-for="stream in streams">
        <option :value="stream.id">
            {{stream.stream_name}}
        </option>
    </template>
</select>
</div>   


<!-- зависит от группы currentStream -->
<select v-model="currentStudent">
    <template v-for="student in students">
        <option :value="student.id">
            {{student.fio}}
        </option>
    </template>
</select>
 
<br>

<!-- зависит от группы currentStream -->
<select v-model="currentDisciplins">
    <template v-for="discipline in disciplins">
        <option :value="discipline.id">
            {{discipline.discipline_name}}
        </option>
    </template>
</select>
 
<br>




</template>

<script>
    export default {


    data() {
        return {
            streams: null,
            students: null,
            disciplins: null,
            currentStream: null,
            currentStudent: null,
            currentDisciplins: null,
        }
    },
    
    mounted() {
            this.getStreams()
        },    

    methods: {
        getStreams() {
            axios.get('/api/streams')
            .then(response => {
                this.streams = response.data
            })
        },

        changeCurrentStream(){
            console.log(this.currentStream);
            this.getStudents();
            this.getDisciplins();
        },

        getStudents() {
            axios.get(`/api/streams/${this.currentStream}/students`)
            .then(response => {
                
                this.students = response.data
            })
        },

        getDisciplins() {
            axios.get(`/api/streams/${this.currentStream}/disciplins`)
            .then(response => {
                console.log(response.data)
                this.disciplins = response.data
            })
        }
    }

    }
</script>
