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
            <button type="button" class="close" @click="closeModal()" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-row">
              <div class="form-group">
                <button
                  @click="openOption('clientOptionDiv')"
                  class="btn btn-secondary btn-sm dropdown-toggle"
                >By Client</button>
                <button
                  disabled
                  @click="openOption('VisitOptionDiv')"
                  class="btn btn-secondary btn-sm dropdown-toggle"
                >By Visit-date</button>
              </div>
            </div>
            <div id="clientOptionDiv">
              <div class="card  bg-dark mb-3 shadow-sm" style="max-width: 18rem;">
                <!-- <div class="card-header">By Client</div> -->
                <div class="card-body">
                  <div class="form-row mt-3">
                    <div class="col-12">
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
                  </div>
                  <div class="form-row mt-2">
                    <div class="col-12">
                      <select
                        name="selectClient"
                        id="selectClient"
                        v-model="selectedStatus"
                        class="form-control"
                      >
                        <option disabled value>Select Status</option>
                        <option :value="2">All</option>
                        <option :value="0">Open</option>
                        <option :value="1">Closed</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="col-2">
                      <label for="from">From:</label>
                      <vuejs-datepicker name="from" v-model="startDate"></vuejs-datepicker>
                      <label for="till">Till:</label>
                      <vuejs-datepicker name="till" v-model="endDate"></vuejs-datepicker>
                    </div>
                  </div>
                  <div class="form-row mt-2">
                    <div class="form-group">
                      <a class="btn btn-primary" @click="getReportbyClients()" href="#">Generate</a>
                      <a v-if="reportGenerated" @click="save('#test')" class="btn btn-primary" href="#">Save file</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- end of Client Option div -->
            <div id="VisitOptionDiv">
              <div class="card  bg-dark mb-3" style="max-width: 18rem;">
                <!-- <div class="card-header">Header</div> -->
                <div class="card-body">
                  <div class="form-row mt-3">
                <div class="col-12">
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
              </div>
              
              <div class="form-row">
                <div class="col-12">
                  <label for="visitDate">Inspection date:</label>
                  <vuejs-datepicker name="visitDate" v-model="inspectionDate"></vuejs-datepicker>
                </div>
              </div>
              <div class="form-row mt-2">
                <div class="form-group">
                  <a class="btn btn-primary" href="#">Generate</a>
                  <a  @click="save('#test')" class="btn btn-primary" href="#">Save file</a>
                </div>
              </div>
            </div>
                 
                </div>
              </div>
               <!--End Of By Inspection -->

            <div id="hiddenTable" class="form-row mt-5">
              <table class="table" id="test" style="overflow-y : scroll">
                <thead>
                  <tr>
                    <th>Client</th>
                    <th>Kind</th>
                    <th>Class</th>
                    <th>Date</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Status</th>
                    <th>Cause</th>
                    <th>Inspection Dates</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(job, index) in reportData">
                    <td>{{job.client.name}}</td>
                    <td v-if="job.pricetag.kind != null">{{job.pricetag.kind}}</td>
                    <td v-else></td>
                    <td>{{job.pricetag.name}}</td>
                    <td>{{$root.getFormattedDate(job.created_at)}}</td>
                    <td>{{job.address}}</td>
                    <td>{{job.city}}</td>
                    <td>{{$root.representStatus(job.done)}}</td>

                    <td v-if="job.cause != null">{{job.cause}}</td>
                    <td v-else>Undefined</td>
                    <td
                      v-if="job.inspections.length > 0 "
                    >{{getAddedInspectionDates(job.inspections)}}</td>
                    <td v-else>No inspections</td>
                    <td>{{job.pricetag.cost}}</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total in €</td>
                    <td>=sum(J2:J{{reportData.length + 1}})</td>
                  </tr>
                </tbody>
              </table>

              <br>
              <br>
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
      reportData: [],
      selectedClientId: "",
      selectedStatus: "",
      URI: "/generate/",
      startDate: new Date(),
      endDate: new Date(),
      inspectionDate: new Date(),
      openOptionDiv: "none",
      hideDivArray: ["VisitOptionDiv", "clientOptionDiv","test"],
      reportByClientUri: "/reportclient/",
      reportGenerated: false
    };
  },
  props: {
    clients: Array
  },

  methods: {
    getAddedInspectionDates(inspections) {
      let dates = "";

      inspections.forEach(function(i) {
        let year = i.created_at.toString().substring(0, 4);
        let month = i.created_at.toString().substring(5, 7);
        let day = i.created_at.toString().substring(8, 10);

        dates = dates + day + " - " + month + " - " + year + " || ";
      });

      return dates;
    },
    init() {
      this.hideDivArray.forEach(name => {
        let div = document.getElementById(name);
        div.style.display = "none";
      });
    },

    openOption(divName) {
      if (this.openOptionDiv != divName) {
        if (this.openOptionDiv != "none") {
          let oldDiv = document.getElementById(this.openOptionDiv);
          oldDiv.style.display = "none";
        }
        let newDiv = document.getElementById(divName);

        newDiv.style.display = "block";
        this.openOptionDiv = divName;
      } else {
        let newDiv = document.getElementById(divName);
        newDiv.style.display = "none";
        this.openOptionDiv = "none";
      }
    },
    closeModal(){
      this.reportGenerated = false;
       $("#ReportModal").modal("hide");
    },
    getReportbyClients() {
      axios
        .get(this.reportByClientUri, {
          params: {
            client_id: this.selectedClientId,
            startDate: this.startDate,
            endDate: this.endDate,
            status: this.selectedStatus
          }
        })
        .then(response => {
          this.reportData = response.data.jobs;
          this.reportGenerated = true;
        });
    },
    download_csv(csv, filename) {
      var csvFile;
      var downloadLink;

      // CSV FILE
      csvFile = new Blob([csv], { type: "text/csv" });

      // Download link
      downloadLink = document.createElement("a");

      // File name
      downloadLink.download = filename;

      // We have to create a link to the file
      downloadLink.href = window.URL.createObjectURL(csvFile);

      // Make sure that the link is not displayed
      downloadLink.style.display = "none";

      // Add the link to your DOM
      document.body.appendChild(downloadLink);

      // Lanzamos
      downloadLink.click();
    },
    export_table_to_csv(htmlTable, filename) {
      var csv = [];
      var container = document.querySelector(htmlTable);
      var rows = container.querySelectorAll("table tr");

      for (var i = 0; i < rows.length; i++) {
        var row = [],
          cols = rows[i].querySelectorAll("td, th");

        for (var j = 0; j < cols.length; j++) row.push(cols[j].innerText);

        csv.push(row.join(","));
      }

      // Download CSV
      this.download_csv(csv.join("\n"), filename);
    },

    openReportModal() {
      $("#ReportModal").modal("show");
    },

    save(htmlTable) {
      // var html = document.getElementById("test").outerHTML;
      this.export_table_to_csv(htmlTable, "table.csv");
       this.closeModal();
    }
  },
  computed: {},
  mounted() {
    this.init();
    console.log("RaportComponent mounted.");
  }
};
</script>
