<template>
  <div class="col-6">
    <!-- Area Chart -->
    <div>
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
                  <th style="width: 50%" scope="col">Name</th>
                  <th style="width: 10%" scope="col"></th>

                  <th style="width: 10%"></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(client, index) in clients">
                  <!-- <td>{{index + 1}}</td> -->
                  <td>{{client.name}}</td>

                  <td>
                    <i @click="openEditClientModal(index)" class="fas fa-tools fa-1x"></i>
                  </td>
                  <td>
                    <i @click="deleteClient(index)" class="fas fa-minus-circle fa-1x"></i>
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
    <!-- Update Modal -->
    <div
      class="modal fade"
      id="edit-client-modal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Client</h5>
            <button type="button" class="close" @click="closeEditClientModal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="updateclientname">Name:</label>
              <input
                v-model="new_update_client.name"
                type="text"
                id="updateclientname"
                class="form-control"
              >

              <div class="form-group row">
                <div class="col-4 mt-2">
                  <label for="pricetagkind">Kind:</label>
                  <input v-model="pricetag.kind" type="text" id="pricetagkind" class="form-control">
                </div>
                <div class="col-4 mt-2">
                  <label for="pricetagname">Pricetags:</label>
                  <input v-model="pricetag.name" type="text" id="pricetagname" class="form-control">
                </div>
                <div class="col-3 mt-2">
                  <label for="pricetagcost">cost:</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text" id="btnGroupAddon">€</div>
                    </div>
                    <input
                      v-model="pricetag.cost"
                      type="text"
                      id="pricetagcost"
                      class="form-control"
                      aria-describedby="btnGroupAddon"
                    >
                  </div>
                </div>
                <div class="col-1 mt-2">
                  <label for="pricetagcost">Save:</label>
                  <div>
                    <i @click="createPriceTag()" class="far fa-check-circle fa-2x"></i>
                  </div>
                </div>
              </div>
            </div>
            <div>
              <hr>
            </div>
            <div class="row">
              <div class="col-12">
                <table class="table" v-if="new_update_client.pricetags">
                  <thead>
                    <th style="width: 50%">available tags</th>
                    <th style="width: 25%"></th>
                    <th style="width: 25%">Cost in €</th>
                    <th style="width: 25%"></th>
                  </thead>
                  <tbody>
                    <tr v-for="(pricetag, index) in new_update_client.pricetags">
                      <td>{{pricetag.kind}}</td>
                      <td>{{pricetag.name}}</td>
                      <td>{{pricetag.cost}}</td>
                      <td>
                        <i @click="deletePriceTag(index)" class="far fa-times-circle fa-2x"></i>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="closeEditClientModal">Close</button>
              <button type="button" @click="updateClient" class="btn btn-primary">Save changes</button>
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
      pricetag: {
        name: "",
        kind: "",
        cost: "",
        client_id: ""
      },

      pricetags: [],

      // clients: [],

      restoreClient: {},

      toast: (toastr.options = { positionClass: "toast-top-full-width" }),

      errors: [],

      new_update_client: [],

      uri: "/clients/"
    };
  },
  props: {
    clients: Array
  },
  methods: {
    resetData() {
      this.client.name = "";
    },
    openCreateClientModal() {
      this.resetData();
      $("#create-client-modal").modal("show");
    },
    openEditClientModal(index) {
      this.errors = [];
      $("#edit-client-modal").modal("show");
      this.new_update_client = this.clients[index];
      // resores Client to previous when canceled
      this.restoreClient = Object.assign({}, this.clients[index]);
    },
    closeCreateClientModal() {
      $("#create-client-modal").modal("hide");
    },
    closeEditClientModal() {
      Object.assign(this.new_update_client, this.restoreClient);
      this.restoreClient = null;
      $("#edit-client-modal").modal("hide");
    },
    createClient() {
      axios
        .post(this.uri, {
          name: this.client.name
        })
        .then(response => {
          this.clients.push(response.data.client);
          this.$root.getClients();
          this.resetData();
          this.closeCreateClientModal();
          this.$root.messageSuccess('Client added');
        }).catch(error => {
          this.$root.messageError(error);
        });;
    },
    createPriceTag() {
      axios
        .post("/pricetags", {
          kind: this.pricetag.kind,
          name: this.pricetag.name,
          cost: this.pricetag.cost,
          client_id: this.new_update_client.id
        })
        .then(response => {
          this.new_update_client.pricetags.push(response.data.pricetag);
          this.resetPriceTagData();

           this.$root.messageSuccess('Pricetag created');
        })
        .catch(error => {
          this.$root.messageError(error);
        });
    },

    init() {
      this.clients = this.$root.$data;
    },

    updateClient() {
      axios
        .patch(this.uri + this.new_update_client.id, {
          name: this.new_update_client.name
        })
        .then(response => {
          $("#edit-client-modal").modal("hide");
          this.$root.messageSuccess('Client Updated');
        })
        .catch(error => {
          this.$root.messageError(error);
        });
    },

    deleteClient(index) {
      let confirmbox = confirm(
        "Do you realy want to delete this Client ? Pricetags won't be deleted. If you want them gone delete them first"
      );

      if (confirmbox == true) {
        axios
          .delete(this.uri + this.clients[index].id)
          .then(response => {
            this.$delete(this.clients, index);
             
          })
          .catch(error => {
          this.$root.messageError('could not delete');
        });
      }
    },
    deletePriceTag(index) {
      let confirmbox = confirm(
        "Let's think of the consequences first shall we ? It's best to update all jobs with a new pricetag first"
      );

      if (confirmbox == true) {
        axios
          .delete("/pricetags/" + this.new_update_client.pricetags[index].id)
          .then(response => {
            this.$delete(this.new_update_client.pricetags, index);
          })
          .catch(error => {
          this.$root.messageError('Could not delete Pricetag');
        });
      }
    },
    resetPriceTagData() {
      this.pricetag.name = "";
      this.pricetag.cost = "";
      this.pricetag.client_id = "";
    }
  },

  mounted() {
    console.log("Client Component mounted.");
  }
};
</script>
