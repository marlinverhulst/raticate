<template>
  <div>
    <div class="row justify-content-center mt-1">
      <div class="col-10 mt-1" v-for="(date, index) in visitDates">
        <button
          @click="loadJobs(date.visitdate, index)"
          class="btn btn-dark btn-block shadow"
          type="button"
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
            <div v-for="(job, index) in openJobs" class="btn-group">
              <button
                type="button"
                class="btn dropdown-toggle shadow-sm"
                @click="startInspection(index)"
              >
                {{job.address}}&nbsp; - &nbsp;{{job.city}}&nbsp;&nbsp;
                <div class="float-right">
                  <i v-if="job.time" class="far fa-clock"></i>
                  <i v-if="job.callfirst" class="fas fa-phone"></i>
                </div>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="visitModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{activeJob.address}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row justify-content-center mt-1">
              
                <span v-if="activeJob.time != null && activeJob.time != ''" class="border border-danger col-12 pt-3 mb-2"> <p> Time restriction: {{activeJob.time}} </p></span>
                
              <div class="col-10">
                <div v-if="activeJob.inspections != undefined" class="mb-2">
                  <strong>Visit #:&nbsp;{{activeJob.inspections.length + 1}}</strong>
                </div>
                
                <div class="form-group">
                  <label for="description">Description:</label>
                  <textarea
                    class="form-control"
                    disabled
                    name
                    v-model="activeJob.description"
                    id="description"
                    cols="30"
                    rows="5"
                  ></textarea>
                </div>

                <div class="form-group">
                  <label for="observation">Observations:</label>
                  <textarea
                    name
                    v-model="activeJob.comments"
                    id="observation"
                    cols="30"
                    rows="5"
                    class="form-control"
                  ></textarea>
                </div>
                <div class="form-row">
                  <div class="form-group col-8">
                    <label for="causeSelect">Cause :</label>
                    <select v-model="activeJob.cause" class="form-control" id="causeSelect">
                      <option disabled value>Select a Cause</option>
                      <option v-for="cause in causes" :value="cause.name">{{cause.name}}</option>
                    </select>
                  </div>
                </div>

                <div>
                  <hr>
                </div>
                <div class="form-row">
                  <div class="form-group col-8">
                    <label for="statusSelect">Status :</label>
                    <select v-model="activeJob.done" class="form-control" id="statusSelect">
                      <option disabled value>Status of job</option>
                      <option v-for="status in statuses" :value="status.value">{{status.name}}</option>
                    </select>
                  </div>
                </div>
                <!--Date Picker-->

                <div class="form-group mt-2">
                  <div class="mb-1">
                    <strong>Next Visit:</strong>
                  </div>
                  <div v-if="activeJob.done == 0">
                    <vuejs-datepicker name="datepicker" v-model="activeJob.visitdate"></vuejs-datepicker>
                  </div>
                </div>

                <div v-if="activeJob.done == 0" class="form-row">
                  <div class="form-group col-12">
                    <label for="callbeforev">Call before visit ?:</label>
                    <input
                      type="checkbox"
                      name="callbeforev"
                      v-model="activeJob.callfirst"
                      id="callbeforev"
                    >
                  </div>
                </div>
                <div v-if="activeJob.done == 0" class="form-row">
                  <div class="form-group col-12">
                    <input
                      v-model="activeJob.time"
                      type="text"
                      id="time"
                      class="form-control"
                      placeholder="Time restrictions here ..."
                    >
                  </div>
                </div>
                <div class="form-group">
                  <label for="feedback">Feedback for Admin:</label>
                  <textarea
                    name
                    v-model="activeJob.message"
                    class="form-control"
                    id="feedback"
                    cols="30"
                    rows="2"
                  ></textarea>
                </div>
              </div>
              <!-- end of column-->
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
            <button
              v-if="activeJob.done !='No'"
              type="button"
              @click="finishJob()"
              class="btn btn-primary"
            >End Visit</button>
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
      uri: "/technicians/",
      datesUri: "/loaddates/",
      jobsUri: "/loadjobs/",
      visitDates: [],
      openJobs: [],
      activeJob: [],
      indexOfActiveJob: undefined,
      causes: [
        { name: "Voer" },
        { name: "Vervuiling" },
        { name: "Riool" },
        { name: "Sloot" },
        { name: "Vijver" },
        { name: "Overig" }
      ],
      statuses: [
        { name: "Needs extra visit", value: 0 },
        { name: "Job completed", value: 1 }
      ],
      hasOpenTab: undefined
    };
  },
  props: {},

  methods: {
    finishJob() {
      axios
        .patch(this.uri + this.activeJob.id, {
          comments: this.activeJob.comments,
          callfirst: this.activeJob.callfirst,
          time: this.activeJob.time,
          done: this.activeJob.done,
          visitdate: this.activeJob.visitdate,
          cause: this.activeJob.cause,
          message: this.activeJob.message
        })
        .then(response => {

          $("#visitModal").modal("hide");
          this.$root.messageSuccess("Job has been send");
          this.$delete(this.openJobs, this.indexOfActiveJob);
          this.indexOfActiveJob = undefined;
        })
        .catch(error => {
          this.$root.messageError(error);
        });
    },

    closeOpenDateTab(index) {
      if (this.hasOpenTab == undefined) {
        this.hasOpenTab = index;
        $("#collapseExampl" + index).collapse("show");
      } else if (this.hasOpenTab == index) {
        $("#collapseExampl" + index).collapse("hide");
        this.hasOpenTab = undefined;
      } else if (this.hasOpenTab != index && this.hasOpenTab != undefined) {
        $(".collapse").collapse("hide");
        this.hasOpenTab = undefined;
        $("#collapseExampl" + index).collapse("show");
        this.hasOpenTab = index;
      }
    },

    getDates() {
      axios.get(this.datesUri).then(response => {
        this.visitDates = response.data.dates;
      });
    },

    startInspection(index) {
      this.activeJob = this.openJobs[index];
      this.activeJob.done = "No";
      this.indexOfActiveJob = index;

      this.openModal("#visitModal");
    },

    openModal(modalId) {
      $(modalId).modal("show");
    },

    loadJobs(date, index) {
      this.closeOpenDateTab(index);

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
