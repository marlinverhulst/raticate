<template>
  <div>
    <!-- Route Builder -->

    <a
      href="#"
      @click="openModal()"
      class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
    >
      <i class="fas fa-route fa-sm text-white-50"></i>
      Route Builder&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </a>
    <!-- Modal -->
    <div
      class="modal fade"
      id="RouteBuilderModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Route Builder</h5>
            <button type="button" class="close" @click="closeModal()" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-row mt-3">
              <div class="col-12">
                <select
                  @change="getDatesForUser(selectedTechnicianId)"
                  name="selectClient"
                  id="selectClient"
                  v-model="selectedTechnicianId"
                  class="form-control"
                >
                  <option disabled value>Select Technician</option>

                  <option v-for="user in getTechnicians" :value="user.id">{{user.name}}</option>
                </select>
              </div>
            </div>
            <hr>
            <div class="form-row mt-3">
              <span v-for="date in dates">
                <button
                  class="btn btn-sm btn-outline-primary mr-1 mb-2"
                  @click="getJobs(selectedTechnicianId,date.visitdate)"
                >{{$root.getFormattedDate(date.visitdate)}}</button>
              </span>
            </div>
            <hr>
            <div class="form-row mt3">
              <div class="col-12">
              <div class="d-flex flex-row align-items-center justify-content-between">
                <table class="table ">
                  <tr>
                    <th>Address</th>
                    <th>Priorty</th>
                    <th>
                      <button
                        @click="updateTheJob()"
                        v-if="jobs.length != 0"
                        class="btn btn-primary btn-sm"
                      >Save Route</button>
                    </th>
                    <th>
                      <button
                        @click="sortJobs()"
                        v-if="jobs.length != 0"
                        class="btn btn-primary btn-sm"
                      >Preview Route</button>
                    </th>
                  </tr>
                  <tr v-for="(job, index) in jobs">
                    <td>{{job.address}} , {{job.city}}</td>
                    <td>
                      <input type="number" id v-model="job.priority">
                    </td>
                    <td></td>
                    <td></td>
                  </tr>
                </table>
              </div>
              </div>
            </div>
          </div>
          <!--end of modal body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="closeModal()">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- end of Modal -->
  </div>
  <!-- End Of App -->
</template>

<script>
export default {
  data() {
    return {
      selectedTechnicianId: "",
      datesUri: "routebuilder/",

      dates: [],
      jobs: [],
     
    };
  },
  props: {
    users: Array
  },

  methods: {
    updateTheJob() {
      this.jobs.forEach(job => {
        axios
          .patch(this.datesUri + job.id, {
            priority: parseInt(job.priority, 10)
          })

          .catch(error => {
            this.$root.messageError("Error while saving " + job.address);
          });
      });
      this.$root.messageSuccess("Route has been saves");
    },
    getDatesForUser(userId) {
      this.jobs = [];
      axios.get(this.datesUri, { params: { id: userId } }).then(response => {
        this.dates = response.data.dates;
      });
    },
    getJobs(userId, visitdate) {
      axios
        .get("routebuilderjobs", {
          params: { id: userId, visitdate: visitdate }
        })
        .then(response => {
          this.jobs = response.data.jobs;
          
        });
        
    },
     sortJobs: function() {
      
        return this.jobs.sort(function(a, b) {
        return a.priority - b.priority;

        
      });
      
    },

    openModal() {
      
      $("#RouteBuilderModal").modal("show");
    },
    closeModal() {
      this.jobs = [];
      this.selectedTechnicianId = '';
      this.dates = [];
      $("#RouteBuilderModal").modal("hide");
    }
  },

  computed: {
    // Returns list of technicians filtered from Users
    getTechnicians: function() {
      return this.users.filter(user => {
        return user.role_id == 2;
      });
    }

   
  },
  mounted() {
    console.log("RouteBuilder mounted.");
  }
};
</script>
