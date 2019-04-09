<template>
  <div class="col-12">
    <!-- Area Chart -->
    <div>
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <i
            @click="$root.setJobStatus(1)"
            v-if="$root.jobstatus == 0"
            class="fas fa-folder-open fa-3x"
          ></i>
          <i @click="$root.setJobStatus(0)" v-else class="fas fa-folder fa-3x"></i>
          <h6 class="m-0 font-weight-bold text-primary">Jobs</h6>
          <i class="fas fa-plus-circle fa-2x" @click="openCreateJobsModal"></i>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <div class="jobscard">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a
                  class="nav-link active"
                  @click="setSearchName('')"
                  id="home-tab"
                  data-toggle="tab"
                  href="#home"
                  role="tab"
                  aria-controls="home"
                  aria-selected="true"
                >All</a>
              </li>
              <li v-for="(client, index) in clients" class="nav-item">
                <a
                  @click="setSearchName(client.name)"
                  class="nav-link {'active' :index == selected }"
                  id="home-tab"
                  data-toggle="tab"
                  href="#home"
                  role="tab"
                  aria-controls="home"
                  aria-selected="true"
                >{{client.name}}</a>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div
                class="tab-pane fade show active"
                id="home"
                role="tabpanel"
                aria-labelledby="home-tab"
              >
                <div class="container">
                  <table class="table">
                    <thead>
                      <th>Client</th>
                      <th>Address</th>
                      <th>zip-code</th>
                      <th>city</th>
                      <th>Status</th>
                      <th># of Visits</th>
                      <th>Planned on:</th>
                      <th>Technician</th>
                    </thead>
                    <tbody>
                      <tr v-for="(job , index) in getJobByName">
                        <td>{{job.client.name}}</td>
                        <td>{{job.address}}</td>
                        <td>{{job.zip}}</td>
                        <td>{{job.city}}</td>
                        <td>{{$root.representStatus(job.done)}}</td>
                        <td v-if="job.inspections != undefined">{{job.inspections.length}}</td>
                        <td v-else>0</td>
                        <td v-if="job.visitdate != undefined">{{$root.getFormattedDate(job.visitdate.date)}}</td>
                        <td v-else>Not Planned</td>
                        <td>{{job.user.name}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- create Modal -->
    <div
      class="modal fade"
      id="create-job-modal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create Job</h5>
            <button type="button" class="close" @click="closeCreateJobsModal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-row">
              <div class="form-group col-6">
                <label for="clientSelect">Client:</label>
                <select
                  v-model="selectedIndex"
                  class="form-control"
                  id="clientSelect"
                  @change="makeSelectedClient()"
                >
                  <option v-for="(client, index) in clients" :value="index">{{client.name}}</option>
                </select>
              </div>
              <div class="form-group col-6">
                <label for="priceTagSelect">&#160;</label>

                <select
                  v-model="job.pricetag_id"
                  v-if="selectedClient.pricetags"
                  class="form-control"
                  id="priceTagSelect"
                  @change="check()"
                >
                  <option disabled value>Select a Pricetag</option>
                  <option
                    v-for="priceTag in selectedClient.pricetags"
                    :value="priceTag.id"
                  >{{priceTag.kind}}&#160;&#160;{{priceTag.name}}: &#160;&#160;&#160;&#160;&#160;€&#160; {{priceTag.cost}}</option>
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-6">
                <input
                  v-model="job.address"
                  type="text"
                  id="adres"
                  class="form-control"
                  required
                  placeholder="Address"
                >
              </div>

              <div class="form-group col-3">
                <input
                  v-model="job.zip"
                  type="text"
                  id="zip"
                  class="form-control"
                  maxlength="6"
                  placeholder="Zipcode"
                >
              </div>

              <div class="form-group col-3">
                <input
                  v-model="job.city"
                  type="text"
                  id="city"
                  class="form-control"
                  required
                  placeholder="City"
                >
              </div>
            </div>
            <div class="form-group">
              <input
                v-model="job.tel"
                type="text"
                id="tel"
                class="form-control"
                maxlength="10"
                placeholder="Tel"
              >
            </div>
            <div class="form-group">
              <textarea
                v-model="job.description"
                name="description"
                id="description"
                cols="30"
                rows="6"
                class="form-control"
                placeholder="Description.."
              ></textarea>
            </div>
            <div class="form-row">
              <div class="form-group col-6">
                <label for="datepicker">Visit date:&nbsp;</label>
                <div v-if="job.noVisit == 0 && job.done == 0 ">
                <vuejs-datepicker name="datepicker" v-model="job.visitDate"></vuejs-datepicker>
                </div>
              </div>
              <div class="form-group" col-6>
                <label for="novisit">&nbsp;Do not visit ?&nbsp;</label>
                <input type="checkbox" name="novisit" v-model="job.noVisit" id="novisit">
              </div>
            </div>
            <div class="form-group">
              <label for="done">Job closed ?&nbsp;</label>
              <input type="checkbox" name="done" v-model="job.done" id="done">
            </div>

            <div class="form-row">
              <div class="form-group col-4">
                <label for="callbefore">Call before visit ?:</label>
                <input type="checkbox" name="callbefore" v-model="job.callfirst" id="callbefore">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-8">
                <input
                  v-model="job.time"
                  type="text"
                  id="time"
                  class="form-control"
                  placeholder="Time restrictions here ..."
                >
              </div>
            </div>
            <div>
              <hr>
            </div>
            <div class="form-row">
              <div class="form-group col-8">
                <label for="clientSelect">Assign to:</label>
                <select
                  v-model="job.user_id"
                  class="form-control"
                  id="clientSelect"
                  @change="check()"
                >
                  <option disabled value>Select a Technician</option>
                  <option
                    v-for="technician in getTechnicians"
                    :value="technician.id"
                  >{{technician.name}}</option>
                </select>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="closeCreateJobsModal">Close</button>
              <button type="button" @click="createJob()" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import vuejsDatepicker from "vuejs-datepicker";

export default {
  components: {
    vuejsDatepicker
  },
  data() {
    return {
      job: {
        address: "",
        zip: "",
        tel: "",
        city: "",
        client_id: "0",
        pricetag_id: "",
        user_id: "",
        description: "",
        visitDate: new Date(),
        callfirst: false,
        time: "",
        done: false,
        noVisit: false,
        cause: ""
      },
      uri: "/jobs/",
      selectedTab: 0,
      selectedIndex: 0,
      selectedClient: [],
      searchName: ""
    };
  },
  props: {
    clients: Array,
    users: Array,
    jobs: Array
  },

  computed: {
    getTechnicians: function() {
      return this.users.filter(user => {
        return user.role_id == 2;
      });
    },
    getJobByName: function() {
      return this.jobs.filter(job => {
        return job.client.name.match(this.searchName);
      });
    }
  },

  methods: {
    

    setSearchName(name) {
      this.searchName = name;
    },
    createJob() {
      axios
        .post(this.uri, {
          address: this.job.address,
          zip: this.job.zip,
          tel: this.job.tel,
          city: this.job.city,
          client_id: this.job.client_id,
          pricetag_id: this.job.pricetag_id,
          user_id: this.job.user_id,
          description: this.job.description,
          callfirst: this.job.callfirst,
          time: this.job.time,
          done: this.job.done,
          visitDate: this.job.visitDate,
          noVisit: this.job.noVisit
        })
        .then(response => {
          this.closeCreateJobsModal();
          this.$root.getJobs();
        });
    },

    clearPricetagId() {
      this.job.pricetag_id = "";
    },
    check() {
      // console.log(this.job.pricetag_id);
      // console.log(this.job.callfirst);
      // console.log(this.job.user_id);
      // console.log(this.job.visitDate);
      console.log(this.job.noVisit);
    },
    makeActive(index) {
      this.selectedTab = index;
    },
    makeSelectedClient() {
      this.clearPricetagId();

      this.selectedClient = this.clients[this.selectedIndex];
      this.job.client_id = this.selectedClient.id;
    },

    openCreateJobsModal() {
      if (this.clients.length > 0) {
        this.selectedClient = this.clients[this.selectedIndex];
        this.job.client_id = this.clients[0].id;
        $("#create-job-modal").modal("show");
        console.log(this.job.client_id);
      } else {
        console.log("No Clients ");
      }
    },
    closeCreateJobsModal() {
      $("#create-job-modal").modal("hide");
      console.log(this.selectedClient.id);
      console.log(this.job.client_id);
      this.check();
    },
    
  },

  mounted() {
    console.log("Job Component mounted.");
  }
};
</script>
