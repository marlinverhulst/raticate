<template>
  <div>
    <!-- Generate Rapport -->

    <a
      @click="openReportModal()"
      href="#"
      class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
    >
      <i class="fas fa-download fa-sm text-white-50"></i>
      Generate Reports
    </a>

    <!-- Modal -->
    <div
      class="modal fade"
      id="ReportModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Generate Reports</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-row">
            <div class="col-3">
              <select
                name="selectClient"
                id="selectClient"
                v-model="selectedClientId"
                class="form-control"
              >
                <option disabled value>Select Client</option>
                <option :value="0">All</option>
                <option v-for="client in clients" :value="client.id">{{client.name}}</option>
              </select>
            </div>
            <div class="col-3">
              <select
                name="selectClient"
                id="selectClient"
                v-model="selectedStatus"
                class="form-control"
              >
                <option disabled value>Select Status</option>
                <option :value="3">All</option>
                <option :value="0">Open</option>
                <option :value="1">Closed</option>
              </select>
            </div>
            <div class="col-3">
              <button @click="generateData()" class="btn btn-primary">Generate</button>
            </div>
            </div>

          </div> <!--end of modal body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <!-- end of Modal -->
  </div>
  <!-- end of component div -->
</template>

<script>
export default {
  data() {
    return {
      selectedClientId: "",
      selectedStatus: "",
      URI: "/generate/"
    };
  },
  props: {
    clients: Array
  },

  methods: {
    openReportModal() {
      $("#ReportModal").modal("show");
    },
    generateData() {
      console.log(this.selectedClientId);
      console.log(this.selectedStatus);
    }
  },

  computed: {},
  mounted() {
    console.log("RaportComponent mounted.");
  }
};
</script>
