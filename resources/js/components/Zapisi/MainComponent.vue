<template>

    <div style="float: right;">
        <router-link :to="{name: 'records.index'}" class="boot">Записавшиеся</router-link>
    </div>
    <div id="main">

        <div class="conteiner">
            <label>Группа</label>
            <br>
            <select class="box_selector" v-model="currentGroup" @change="changeCurrentGroup()">
                <template v-for="group in groups">
                    <option :value="group.id">
                        {{ group.title }}
                    </option>
                </template>
            </select>
        </div>


        <!-- зависит от группы currentGroup -->
        <div class="conteiner">
            <label>Студент</label>
            <br>
            <select class="box_selector" v-model="currentStudent" @change="getDays()">

                <template v-for="student in students">
                    <option :value="student.id">
                        {{ student.fio }}
                    </option>
                </template>
            </select>
        </div>


        <!-- зависит от группы currentGroup -->
        <div class="conteiner">
            <label>Дисциплина</label>
            <br>
            <select class="box_selector" v-model="currentDiscipline" @change="getLabs()">
                <template v-for="discipline in disciplins">
                    <option :value="discipline.id">
                        {{ discipline.title }}
                    </option>
                </template>
            </select>
        </div>


        <!-- зависит от группы currentGroup -->
        <div class="conteiner">
            <label>Дата</label>
            <br>
            <select class="box_selector" v-model="currentDay" @change="changeCurrentDay()">
                <template v-for="day in days">
                    <option :value="day.id">
                        {{ day.day }}
                    </option>
                </template>
            </select>
        </div>


        <!-- зависит от дня currentDay -->
        <div class="conteiner">
            <label>Время</label>
            <br>
            <select class="box_selector" v-model="currentLabLesson" @change="changeCurrentDayTime()">
                <template v-for="labLesson in labLessons">
                    <option :value="labLesson">
                        {{ labLesson.time_lesson.title }}
                    </option>
                </template>
            </select>
        </div>
        <div class="conteiner">
            <label>Кабинет</label>
            <br>
            <select class="box_selector" v-model="currentLabLesson.cabinet">
                <option :value="currentLabLesson.cabinet">
                    {{ currentLabLesson.cabinet.title }}
                </option>
            </select>
        </div>
        <div class="conteiner">
            <label>Преподаватель</label>
            <br>
            <select class="box_selector" v-model="currentLabLesson.teacher">
                <option :value="currentLabLesson.teacher">
                    {{ currentLabLesson.teacher.fio }}
                </option>
            </select>
        </div>


        <template v-if="(abilityRecord.free_switches || abilityRecord.free_routers)">
            Свободно: <b>{{ abilityRecord.free_routers }}</b> роутера(ов), <b>{{ abilityRecord.free_switches }}</b>
            коммутатора(ов)
            <br><br>
        </template>
        <div class="conteiner">
            <label>Лаборатнорная</label>
            <br>
            <select class="box_selector" v-model="currentLab" @change="checkEquipment()">
                <template v-for="lab in labs">
                    <option :value="lab">
                        {{ lab.title }}
                    </option>
                </template>
            </select>
        </div>
    </div>
    <br>

    <template v-if="abilityRecord.error">
        {{ abilityRecord.error }}
    </template>


    <template v-if="abilityRecord.error">
        <div>
            <button disabled class="boot">
                Записаться
            </button>
        </div>
    </template>


    <template v-if="!abilityRecord.error">
        <div>
            <button class="boot" @click="sendRecord()">
                Записаться
            </button>
        </div>

    </template>
    <br>


</template>


<script>

export default {
    data() {
        return {
            groups: null,
            students: null,
            disciplins: null,
            currentGroup: null,
            currentStudent: null,
            currentDiscipline: null,
            days: null,
            currentDay: null,
            labLessons: null,
            currentLabLesson: {
                'id': null,
                'teacher': {
                    'fio': null,
                },
                'time_lesson': {
                    'id': null,
                    'title': null
                },
                'cabinet': {
                    'id': null,
                    'title': null,
                },
            },
            currentTeacher: null,
            abilityRecord: {
                'error': null,
                'free_seats': null,
                'free_routers': null,
                'free_switches': null,
            },
            labs: null,
            currentLab: {
                'id': null,
                'title': null,
                'routers': null,
                'switches': null
            },

        }
    },

    mounted() {
        this.getGroups()
        this.getDays()
    },

    methods: {
        getGroups() {
            axios.get('/api/groups')
                .then(response => {
                    this.groups = response.data
                })
        },

        changeCurrentGroup() {
            this.getStudents();
            this.getDisciplins();
            this.currentStudent = null
            this.currentDiscipline = null
            this.currentDay = null
        },

        getLabs() {
            axios.get(`/api/disciplins/${this.currentDiscipline}/labs`)
                .then(response => {
                    this.labs = response.data
                })
        },

        getStudents() {
            this.students = null
            axios.get(`/api/groups/${this.currentGroup}/students`)
                .then(response => {
                    this.students = response.data.length !== 0 ? response.data : null
                })
        },

        getDisciplins() {
            this.disciplins = null
            axios.get(`/api/groups/${this.currentGroup}/disciplins`)
                .then(response => {
                    this.disciplins = response.data
                })
        },

        getDays() {
            axios.get(`/api/days`).then(response => {
                this.days = response.data
            })
        },

        changeCurrentDay() {
            axios.get(`/api/days/${this.currentDay}/labLessons`).then(response => {
                this.labLessons = response.data
            })
        },


        changeCurrentDayTime() {
            axios.get(`/api/days/${this.currentDay}/timeLessons/${this.currentLabLesson.time_lesson.id}/students/${this.currentStudent}/cabinets/${this.currentLabLesson.cabinet.id}`).then(response => {
                this.abilityRecord = response.data
            })
        },

        checkEquipment() {
            this.changeCurrentDayTime()
            if (this.abilityRecord.error === undefined) {
                if ((this.abilityRecord.free_routers - this.currentLab.routers) < 0 ||
                    (this.abilityRecord.free_switches - this.currentLab.switches) < 0) {
                    this.abilityRecord.error = `Недостаточно железа! Для вашей лабы нужно ${this.currentLab.routers} роутер(а)(ов), ${this.currentLab.switches} коммутатор(а)(ов)`
                }
            }

        },

        sendRecord() {
            this.checkEquipment()
            let record = {
                'student_id': this.currentStudent,
                'day_id': this.currentDay,
                'time_lesson_id': this.currentLabLesson.time_lesson.id,
                'cabinet_id': this.currentLabLesson.cabinet.id,
                'teacher_id': this.currentLabLesson.teacher.id,
                'lab_id': this.currentLab.id,
                'discipline_id': this.currentDiscipline,
            }
            console.log('send record' + record)
            if (this.abilityRecord.error == null) {
                console.log(record)
                axios.post(`/api/records`, record)
                    .then(response => {
                        console.log(response.data)
                        this.$router.push({name: 'records.index'})
                    })
            }

        }
    }

}
</script>
<script setup>
</script>
