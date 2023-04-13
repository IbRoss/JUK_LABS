




<template>
<div id="main">  
<select class="box_selector" v-model="currentStream" @change="changeCurrentStream()">
    <template v-for="stream in streams">
        <option  :value="stream.id ">
            {{stream.stream_name}}
        </option>
    </template>
</select>
 


<!-- зависит от группы currentStream -->
<select class="box_selector" v-model="currentStudent">
    <template v-for="student in students">
        <option :value="student.id">
            {{student.fio}}
        </option>
    </template>
</select>
 


<!-- зависит от группы currentStream -->
<select class="box_selector" v-model="currentDisciplins">
    <template v-for="discipline in disciplins">
        <option :value="discipline.id">
            {{discipline.discipline_name}}
        </option>
    </template>
</select>
 

<select class="box_selector" v-model="currentDay">
    <template v-for="day in days">
        <option  :value="day.id ">
            {{day.day}}
        </option>
    </template>
</select>
</div>  




</template>

<script>
    export default {


    data() {
        return {
            streams: null,
            students: null,
            disciplins: null,
            days: null,
            currentStream: null,
            currentStudent: null,
            currentDisciplins: null,
            currentDay: null,
        }
    },
    
    mounted() {
            this.getStreams()
            this.getDays()
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
        },
        
        getDays() {
            axios.get('/api/days')
            .then(response => {
                console.log(response.data)
                this.days = response.data
            
            })
        }
        
    }

    }
</script>
