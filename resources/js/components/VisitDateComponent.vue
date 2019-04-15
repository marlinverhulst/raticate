<template>
  <div>
    <div class="row justify-content-center mt-1">
      <div class="col-10 mt-1" v-for="(date, index) in visitDates">
        <button
          @click="loadJobs(date.visitdate)"
          class="btn btn-dark btn-block shadow"
          type="button"
          data-toggle="collapse"
          :data-target="'#collapseExampl' + index"
          aria-expanded="false"
          aria-controls="collapseExample"
        >
          <div class="float-left">
            <i class="far fa-caret-square-down"></i>
          </div>

          <strong>{{formatDate(date.visitdate)}}</strong>
        </button>
        <div class="collapse" :id="'collapseExampl'+ index">
          <div class="card card-body">
            <div v-for="job in openJobs" class="btn-group">
              <button
                type="button"
                class="btn dropdown-toggle shadow-sm"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                {{job.address}}
                <div class="float-right">
                  <i class="fas fa-ambulance"></i>
                  <i class="far fa-clock"></i>
                  <i class="fas fa-phone"></i>
                </div>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end of component div -->
</template>

<script>
import vuejsDatepicker from "vuejs-datepicker";
export default {
  components: {
    vuejsDatepicker
  },
  data() {
    return {
      datesUri: "/loaddates/",
      jobsUri: "/loadjobs/",
      visitDates: [],
      openJobs: []
    };
  },
  props: {},

  methods: {
    getDates() {
      axios.get(this.datesUri).then(response => {
        this.visitDates = response.data.dates;
      });
    },

    loadJobs(date) {
      this.openJobs = [];
      axios
        .get(this.jobsUri, { params: { visitdate: date } })
        .then(response => {
          this.openJobs = response.data.jobs;
        });
    },

    formatDate(date) {
      return this.$parent.getFormattedDate(date);
    }
  },

  computed: {},
  mounted() {
    console.log("Tech side visitdate Component mounted.");
    this.getDates();
  }
};
</script>
