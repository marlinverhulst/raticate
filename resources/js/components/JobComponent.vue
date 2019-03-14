<template>
  <div class="col-12">
    <!-- Area Chart -->
    <div>
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <i class="fas fa-briefcase fa-3x"></i>
          <h6 class="m-0 font-weight-bold text-primary">Jobs</h6>
          <i class="fas fa-plus-circle fa-2x" @click="openCreateJobsModal"></i>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <div class="costumheight">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a
                  class="nav-link active"
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
                  @click="makeActive(index)"
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
              >...
                <p>{{job.client_id}}</p>
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
              <label for="clientSelect"> Client:</label>
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
                >{{priceTag.name}}: &#160;&#160;&#160;&#160;&#160;€&#160; {{priceTag.cost}}</option>
              </select>
            </div>
            </div>

            <div class="form-row">
              <div class="form-group col-6">
              <input v-model="job.address" type="text" id="adres" class="form-control" required placeholder="Address">
              </div>

            
              <div class="form-group col-3">
              <input v-model="job.zip" type="text" id="zip" class="form-control" maxlength="6" placeholder="Zipcode">
              </div>

              <div class="form-group col-3">
              
              <input v-model="job.city" type="text" id="city" class="form-control" required placeholder="City">
              </div>
            </div>
            <div class="form-group">
              
              <input v-model="job.tel" type="text" id="tel" class="form-control"  maxlength="10" placeholder="Tel" >
            </div>
            <div class="form-group">
              
           
              <textarea v-model="job.description" name="description" id="description" cols="30" rows="6" class="form-control" placeholder="Description.."></textarea>
            </div>
            <div class="form-row">
            <div class="form-group col-4">
              <label for="callbefore">Call before visit ?:</label>
              <input type="checkbox" name="callfirst" v-model="job.callfirst" id="callbefore">
              
            </div>
            <div class="form-group col-8">
              
              <input v-model="job.time" type="text" id="time" class="form-control" placeholder="Time restrictions here ..."  >
              
            </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="closeCreateJobsModal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      job: {
        address:"",
        zip:"",
        tel:"",
        city:"",
        client_id: "0",
        pricetag_id: "",
        description:"",
        callfirst:false,
        time:""

      },
      selectedTab: 0,
      selectedIndex: 0,
      selectedClient: []
    };
  },
  props: {
    clients: Array
  },

  methods: {
    clearPricetagId() {
      this.job.pricetag_id = "";
    },
    check() {
      console.log(this.job.pricetag_id);
      console.log(this.job.callfirst);
    },
    makeActive(index) {
      this.selectedTab = index;
    },
    makeSelectedClient() {
      this.clearPricetagId();

      this.selectedClient = this.clients[this.selectedIndex];
    },

    openCreateJobsModal() {
      this.selectedClient = this.clients[this.selectedIndex];
      $("#create-job-modal").modal("show");
    },
    closeCreateJobsModal() {
      $("#create-job-modal").modal("hide");
      console.log(this.selectedClient.id);
      console.log(this.job.client_id);
      this.check();
    }
  },

  mounted() {
    console.log("Job Component mounted.");
  }
};
</script>
