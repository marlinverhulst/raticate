<template>
  <div class="col-6" >
    <!-- Area Chart -->
    <div >
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <i class="fas fa-user-tie fa-3x"></i>
          <h6 class="m-0 font-weight-bold text-primary">Clients</h6>
          <i @click="openCreateClientModal" class="fas fa-plus-circle fa-2x"></i>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <div class="costumheight">
          <table class="table" v-if="clients.length > 0">
            <thead>
              <tr>
                <!-- <th scope="col">Id</th> -->
                <th scope="col">Name</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(client, index) in clients">
                <!-- <td>{{index + 1}}</td> -->
                <td>{{client.name}}</td>
                <td v-for="pricetag in client.pricetags  " >{{pricetag.name}}</td>

                <td>
                  <i @click="UpdateClient(index)" class="fas fa-tools fa-1x"></i>
                </td>
              </tr>
            </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>
    <!-- create Modal -->
    <div
      class="modal fade"
      id="create-client-modal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create Client</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="clientname">Name:</label>
              <input v-model="client.name" type="text" id="clientsname" class="form-control">
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="closeCreateClientModal">Close</button>
              <button type="button" @click="createClient" class="btn btn-primary">Save changes</button>
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
      client: {
        name: ""
      },
      clients: [],
      toast: (toastr.options = { positionClass: "toast-top-full-width" }),

      uri: "http://raticate.test/clients/"
    };
  },
  methods: {
    resetData() {
      this.client.name = "";
    },
    openCreateClientModal() {
      $("#create-client-modal").modal("show");
    },
    closeCreateClientModal() {
      $("#create-client-modal").modal("hide");
    },
    createClient() {
      axios
        .post(this.uri, {
          name: this.client.name
        })
        .then(response => {
          this.clients.push(response.data.client);
          this.resetData();
          this.closeCreateClientModal();
          toastr.success(response.data.message);
        });
    },
    getClients() {
      axios
        .get(this.uri)
        .then(response => {
          this.clients = response.data.clients;
        });
    },

    deleteClient(index) {
      let confirmbox = confirm("Do you realy want to delete this Client ?");

      if (confirmbox == true) {
        axios
          .delete(this.uri + this.clients[index].id)
          .then(response => {
            this.$delete(this.clients, index);
          })
          .catch(error => {
            console.log("could not delete");
          });
      }
    }
  },

  mounted() {
    console.log("Component mounted.");
    console.log(this.clients);
    this.getClients();
  }
};
</script>
