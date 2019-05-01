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
                      <th style="width: 10%" scope="col"></th>
                      <th style="width: 10%" scope="col"></th>
                    </thead>
                    <tbody>
                      <tr v-for="(job , index) in getJobByName">
                        <td v-if="job.client != undefined">{{job.client.name}}</td><td v-else>Undefined client  </td>
                        <td>{{job.address}}</td>
                        <td>{{job.zip}}</td>
                        <td>{{job.city}}</td>
                        <td>{{$root.representStatus(job.done)}}</td>
                        <td v-if="job.inspections != undefined">{{job.inspections.length}}</td>
                        <td v-else>0</td>
                        <td
                          v-if="job.visitdate != undefined"
                        >{{$root.getFormattedDate(job.visitdate)}}</td>
                        <td v-else>Not Planned</td>
                        <td v-if="job.user != undefined">{{job.user.name}}</td><td v-else>Undefined technician</td>
                        <td>
                          <i
                            v-if="searchName == ''"
                            @click="openUpdateJobModal(index)"
                            class="fas fa-tools fa-1x"
                          ></i>
                        </td>
                        <td>
                          <i
                            v-if="searchName == ''"
                            @click="deleteJob(index)"
                            class="fas fa-minus-circle fa-1x"
                          ></i>
                        </td>
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
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create Job</h5>
            <button type="button" class="close" @click="closeCreateJobsModal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body2">
            <div style="margin: 20px">
              <div class="form-row">
                <div class="form-group col-6">
                  <!-- <label for="clientSelect">Client:</label> -->
                  <select
                    v-model="selectedIndex"
                    class="form-control"
                    id="clientSelect"
                    @change="makeSelectedClient()"
                    @click="makeSelectedClient()"
                  >
                    <option v-for="(client, index) in clients" :value="index">{{client.name}}</option>
                  </select>
                </div>
                <div class="form-group col-6">
                  <!-- <label for="priceTagSelect">&#160;</label> -->

                  <select
                    v-model="job.pricetag_id"
                    v-if="selectedClient.pricetags"
                    class="form-control"
                    id="priceTagSelect"
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
                <div class="form-group col-6">
                  <label for="novisit">&nbsp;Do not visit ?&nbsp;</label>
                  <input type="checkbox" name="novisit" v-model="job.noVisit" id="novisit">
                  <label for="done">Job closed ?&nbsp;</label>
                  <input type="checkbox" name="done" v-model="job.done" id="done">
                </div>
              </div>
              <div class="form-group"></div>

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

              <div class="form-row">
                <div class="form-group col-8">
                  <label for="TechnSelect">Assign to:</label>
                  <select v-model="job.user_id" class="form-control" id="TechnSelect">
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

    <!--Update Modal -->
    <div
      class="modal fade"
      id="update-job-modal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="updateExampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="updateExampleModalLabel">Update Job</h5>
            <button type="button" class="close" @click="closeUpdateJobModal()" aria-label="Cancel">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body2">
            <div style="margin: 20px">
              <div class="form-row">
                <div class="form-group col-6">
                  <!-- <label for="clientSelect">Client:</label> -->
                  <select
                    v-model="updateSelectedIndex"
                    class="form-control"
                    id="updateClientSelect"
                    @change="makeUpdateSelectedClient()"
                    @click="makeUpdateSelectedClient()"
                  >
                    <option v-for="(client, index) in clients" :value="index">{{client.name}}</option>
                  </select>
                </div>
                <div class="form-group col-5">
                  <!-- <label for="priceTagSelect">&#160;</label> -->

                  <select
                    v-model="updateJob.pricetag_id"
                    v-if="updateSelectedClient.pricetags"
                    class="form-control"
                    id="priceTagSelect"
                  >
                    <option disabled value>Select a Pricetag</option>
                    <option
                      v-for="priceTag in updateSelectedClient.pricetags"
                      :value="priceTag.id"
                    >{{priceTag.kind}}&#160;&#160;{{priceTag.name}}: &#160;&#160;&#160;&#160;&#160;€&#160; {{priceTag.cost}}</option>
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-6">
                  <input
                    v-model="updateJob.address"
                    type="text"
                    id="updateAdres"
                    class="form-control"
                    required
                    placeholder="Address"
                  >
                </div>

                <div class="form-group col-3">
                  <input
                    v-model="updateJob.zip"
                    type="text"
                    id="updateZip"
                    class="form-control"
                    maxlength="6"
                    placeholder="Zipcode"
                  >
                </div>

                <div class="form-group col-3">
                  <input
                    v-model="updateJob.city"
                    type="text"
                    id="updateCity"
                    class="form-control"
                    required
                    placeholder="City"
                  >
                </div>
              </div>
              <div class="form-group">
                <input
                  v-model="updateJob.tel"
                  type="text"
                  id="updateTel"
                  class="form-control"
                  maxlength="10"
                  placeholder="Tel"
                >
              </div>
              <div class="form-group">
                <textarea
                  v-model="updateJob.description"
                  name="updateDescription"
                  id="updateDescription"
                  cols="30"
                  rows="6"
                  class="form-control"
                  placeholder="Description.."
                ></textarea>
              </div>
              <div class="form-group">
                <textarea
                  v-model="updateJob.comments"
                  name="updateComments"
                  id="updateComments"
                  cols="30"
                  rows="6"
                  class="form-control"
                  placeholder="Comments from technician.."
                ></textarea>
              </div>
              <div class="form-group">
                <textarea
                  v-model="updateJob.message"
                  name="updateComments"
                  id="updateComments"
                  cols="30"
                  rows="6"
                  class="form-control"
                  placeholder="Message for admin.."
                ></textarea>
              </div>
              <div class="form-row">
                <div class="form-group col-8">
                  <label for="updateCauseSelect">Cause :</label>
                  <select v-model="updateJob.cause" class="form-control" id="updateCauseSelect">
                    <option disabled value>Select a Cause</option>
                    <option v-for="cause in causes" :value="cause.name">{{cause.name}}</option>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-6">
                  <label for="updateDatepicker">Visit date:&nbsp;</label>
                  <div v-if="updateJob.noVisit == 0 && updateJob.done == 0 ">
                    <vuejs-datepicker name="updateDatepicker" v-model="updateJob.visitDate"></vuejs-datepicker>
                  </div>
                  <div v-else>
                    <p>Visitdate has been set.. press Do not visit 2x to reset it.</p>
                  </div>
                </div>
                <div class="form-group col-6">
                  <label for="updateNovisit">&nbsp;Do not visit ?&nbsp;</label>
                  <input
                    type="checkbox"
                    name="updateNovisit"
                    v-model="updateJob.noVisit"
                    id="updateNovisit"
                  >
                  <label for="updateDone">Job closed ?&nbsp;</label>
                  <input type="checkbox" name="updateDone" v-model="updateJob.done" id="updateDone">
                </div>
              </div>
              <div class="form-group"></div>

              <div class="form-row">
                <div class="form-group col-4">
                  <label for="updateCallbefore">Call before visit ?:</label>
                  <input
                    type="checkbox"
                    name="updateCallbefore"
                    v-model="updateJob.callfirst"
                    id="updateCallbefore"
                  >
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-8">
                  <input
                    v-model="updateJob.time"
                    type="text"
                    id="updateTime"
                    class="form-control"
                    placeholder="Time restrictions here ..."
                  >
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-8">
                  <label for="UpdateTechnSelect">Assign to:</label>
                  <select v-model="updateJob.user_id" class="form-control" id="UpdateTechnSelect">
                    <option disabled value>Select a Technician</option>
                    <option
                      v-for="technician in getTechnicians"
                      :value="technician.id"
                    >{{technician.name}}</option>
                  </select>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="closeUpdateJobModal()">Close</button>
                <button type="button" @click="updateTheJob()" class="btn btn-primary">Save changes</button>
              </div>
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

      causes: [
        { name: "Voer" },
        { name: "Vervuiling" },
        { name: "Riool" },
        { name: "Sloot" },
        { name: "Vijver" },
        { name: "Overig" }
      ],
      updateJob: [],

      uri: "/jobs/",

      selectedTab: 0,
      selectedIndex: 0,
      updateSelectedIndex: 0,
      selectedClient: [],
      updateSelectedClient: [],
      searchName: "",
      restoreJob: {}
    };
  },
  props: {
    clients: Array,
    users: Array,
    jobs: Array
  },

  computed: {
    // Returns list of technicians filtered from Users 
    getTechnicians: function() {
      return this.users.filter(user => {
        return user.role_id == 2;
      });
    },
    //Filters list of jobs based on the clicked tab in table
    getJobByName: function() {
      if (this.jobs.length > 0) {
        return this.jobs.filter(job => {
          if(job.client != undefined){
          return job.client.name.match(this.searchName);
          }else{
            return "Undefined";  
          }

        });
      }
    }
  },

  methods: {
    updateTheJob() {
      axios
        .patch(this.uri + this.updateJob.id, {
          address: this.updateJob.address,
          zip: this.updateJob.zip,
          tel: this.updateJob.tel,
          city: this.updateJob.city,
          client_id: this.updateJob.client_id,
          pricetag_id: this.updateJob.pricetag_id,
          user_id: this.updateJob.user_id,
          description: this.updateJob.description,
          visitDate: this.updateJob.visitDate,
          callfirst: this.updateJob.callfirst,
          comments: this.updateJob.comments,
          time: this.updateJob.time,
          done: this.updateJob.done,
          noVisit: this.updateJob.noVisit,
          cause: this.updateJob.cause,
          message: this.updateJob.message
        })
        .then(response => {
          $("#update-job-modal").modal("hide");
          this.$root.getJobs();
          this.$root.messageSuccess("Job Updated");
        })
        .catch(error => {
          this.$root.messageError("Client, pricetag and technician are required !");
        });
    },
    //passes the "clients name" for filtering the clients tabs
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
          this.$root.messageSuccess("Job created");
        })
        .catch(error => {
          this.$root.messageError(
            "Client, pricetag and technician are required !"
          );
        });
    },

    clearPricetagId() {
      this.job.pricetag_id = "";
    },

    makeActive(index) {
      this.selectedTab = index;
    },
    // fucntion for switching clients in create/update. pricetag needs to be reset before switching. 
    makeSelectedClient() {
      this.clearPricetagId();

      this.selectedClient = this.clients[this.selectedIndex];
      this.job.client_id = this.selectedClient.id;
    },
    // fucntion for switching clients in create/update. pricetag needs to be reset before switching. 
    makeUpdateSelectedClient() {
      this.updateJob.pricetag_id = "";
      this.updateSelectedClient = this.clients[this.updateSelectedIndex];
      this.updateJob.client_id = this.updateSelectedClient.id;
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
    openUpdateJobModal(index) {
      this.updateJob = this.jobs[index];
      this.updateJob.done == 0;
      this.updateJob.noVisit == 0;

      $("#update-job-modal").modal("show");

      // resores Job to previous when canceled
      this.restoreJob = Object.assign({}, this.jobs[index]);
    },

    closeUpdateJobModal() {
      Object.assign(this.updateJob, this.restoreJob);
      this.restoreJob = null;
      this.updateSelectedClient = [];
      $("#update-job-modal").modal("hide");
    },

    closeCreateJobsModal() {
      $("#create-job-modal").modal("hide");
      console.log(this.selectedClient.id);
      console.log(this.job.client_id);
    },
    deleteJob(index) {
      let confirmbox = confirm(
        "Do you realy want to delete this Job ? Inspections won't be deleted. If you want them gone delete them first"
      );

      if (confirmbox == true) {
        axios
          .delete(this.uri + this.jobs[index].id)
          .then(response => {
            this.$delete(this.jobs, index);
            this.$root.messageSuccess("Job Deleted");
            this.$root.getJobs();
          })
          .catch(error => {
            this.$root.messageError("could not delete");
          });
      }
    }
  },

  mounted() {
    console.log("Job Component mounted.");
  }
};
</script>
