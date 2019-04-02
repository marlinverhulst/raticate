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
              <div class="form-group">
              <button
                @click="openOption('clientOptionDiv')"
                class="btn btn-secondary btn-sm dropdown-toggle"
              >By Client</button>
              <button
                @click="openOption('VisitOptionDiv')"
                class="btn btn-secondary btn-sm dropdown-toggle"
              >By Visit-date</button>
              </div>
            </div>
            <div id="clientOptionDiv">
              <div class="form-row mt-3">
                <div class="col-2">
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
                <div class="col-2">
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
              </div>

              <div  class="form-row">
                <div class="col-2">
                  <label for="from">From date:</label>
                  <vuejs-datepicker name="from" v-model="fromDate"></vuejs-datepicker>
                  <label for="till">Till date:</label>
                  <vuejs-datepicker name="till" v-model="tillDate"></vuejs-datepicker>
                  
                </div>
              </div>
              <div class="form-row mt-2">
                 <div class="form-group">
                    <a class="btn btn-primary" href="#">Generate</a>
                    <a @click="save('#test')" class="btn btn-primary" href="#">Save file</a>
                </div>
              </div>
            </div>
            <!-- end of Client Option div -->
            <div id="VisitOptionDiv">
              <div class="form-row mt-3">
                <div class="col-2">
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
                <div class="col-2">
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
              </div>
              <div class="form-row">
                <div class="col-2">
                  <label for="visitDate">Inspection date:</label>
                  <vuejs-datepicker name="visitDate" v-model="inspectionDate"></vuejs-datepicker>
                  
                </div>
              </div>
              <div class="form-row mt-2">
                
                  <div class="form-group">
                    <a class="btn btn-primary" href="#">Generate</a>
                    <a @click="save('#test')" class="btn btn-primary" href="#">Save file</a>
                </div>
                
                
              </div>
            </div>
            <div id ="hiddenTable" class="form-row mt-5">
              <table class="table" id="test">
                <tr>
                  <th>Name</th>
                  <th>Age</th>
                  <th>Country</th>
                </tr>
                <tr>
                  <td>Geronimo</td>
                  <td>26</td>
                  <td>France</td>
                </tr>
                <tr>
                  <td>Natalia</td>
                  <td>19</td>
                  <td>Spain</td>
                </tr>
                <tr>
                  <td>Silvia</td>
                  <td>32</td>
                  <td>Russia</td>
                </tr>
              </table>
             
              <br>
              <br>
            </div>
             
          </div>
          <!--end of modal body -->
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
import vuejsDatepicker from "vuejs-datepicker";
export default {
  components: {
    vuejsDatepicker
  },
  data() {
    return {
      selectedClientId: "",
      selectedStatus: "",
      URI: "/generate/",
      fromDate: new Date(),
      tillDate: new Date(),
      inspectionDate: new Date(),
      openOptionDiv: "none",
      optionsdDivArray: ["VisitOptionDiv", "clientOptionDiv","hiddenTable"]
    };
  },
  props: {
    clients: Array
  },

  methods: {
    init() {
      this.optionsdDivArray.forEach(name => {
        let div = document.getElementById(name);
        div.style.display = 'none';
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
    }
  },
  computed: {},
  mounted() {
    this.init();
    console.log("RaportComponent mounted.");
  }
};
</script>
