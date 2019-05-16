
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('client-component', require('./components/ClientComponent.vue').default);
Vue.component('search-component', require('./components/SearchComponent.vue').default);
Vue.component('user-component', require('./components/UserComponent.vue').default);
Vue.component('job-component', require('./components/JobComponent.vue').default);
Vue.component('report-component', require('./components/ReportComponent.vue').default);
Vue.component('visit-component', require('./components/VisitDateComponent.vue').default);
Vue.component('adminmessage-component', require('./components/AdminMessageComponent.vue').default);


// register the plugin on vue
import Toasted from 'vue-toasted';

let options = {position: 'top-center', duration: 1500, fullWidth: true, theme: 'outline'};
 
Vue.use(Toasted, options)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: {

    },


    data() {
        return {


            clients: [],
            users: [],
            jobs: [],
            jobstatus: 0,
            searchString: "",

            userUri: "users/",
            jobUri: "jobs/",
            clientUri: "clients/"
        }
    },
    computed: {
        applySearchJobs: function () {
            return this.jobs.filter(job => {
                return job.address.toLowerCase().match(this.searchString.toLowerCase());
            });
        }
    },
    methods: {
        getFormattedDate: function (date) {
            let year = date.toString().substring(0, 4);
            let month = date.toString().substring(5, 7);
            let day = date.toString().substring(8, 10);

            return day + " - " + month + " - " + year;
        },
        representStatus(done) {
            if (done === 0) {
                return "Open";
            } else return "Closed";
        },
        getClients() {
            axios.get(this.clientUri).then(response => {
                this.clients = response.data.clients;
            });
        },
        getUsers() {
            axios
                .get(this.userUri, { name: "none", email: "none@none.com" })
                .then(response => {
                    this.users = response.data.users;
                });
        },

        getJobs() {
            axios.get(this.jobUri, { params: { status: this.jobstatus } }).then(response => { this.jobs = response.data.jobs });
        },

        setJobStatus(status) {
            this.jobstatus = status;
            this.getJobs();
        },
        messageShow(message){
            this.$toasted.show(message);
        },
        messageSuccess(message){
            this.$toasted.success(message);
        },
        messageError(message){
            this.$toasted.error(message);
        }

       

    },
    mounted() {
        this.getClients();
        this.getUsers();
        this.getJobs();
        

        console.log("root mounted");
    },




});


