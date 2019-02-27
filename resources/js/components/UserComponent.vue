<template>
  <div  class="col-6">
    <!-- Area Chart -->
    <div >
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <i class="fas fa-users fa-3x"></i>
          <h6 class="m-0 font-weight-bold text-primary">Users</h6>
          <i @click="openCreateUserModal" class="fas fa-plus-circle fa-2x"></i>
          
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <div class="costumheight">
        <table  class="table " v-if="users.length > 0">
          <thead>
            <tr>
              <!-- <th scope="col">Id</th> -->
              <th scope="col">Name</th>
              <!-- <th scope="col">E-mail</th> -->
              <th scope="col">Function</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            
            <tr v-for="(user, index) in users">
              <!-- <td>{{index + 1}}</td> -->
              <td>{{user.name}}</td>
              <!-- <td>{{user.email}}</td> -->
              <td v-if="user.role_id == 1">Admin</td>
              <td v-else>Technician</td>
              <td><i @click="deleteUser(index)" class="fas fa-minus-circle fa-1x"></i></td>
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
      id="create-modal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="name">Name:</label>
              <input v-model="user.name" type="text" id="name" class="form-control">
            </div>
            <div class="form-group">
              <label for="email">E-mail</label>
              <input type="email" v-model="user.email" id="email" class="form-control">
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" v-model="user.password" id="password" class="form-control">
            </div>
            <div class="form-group">
              <label for="function">Function:</label>
              <button
                type="button"
                id="technicianButton"
                name="function"
                @click="setFunctionToAdmin"
                class="btn btn-primary btn-sm"
              >Technician</button>
              <button
                type="button"
                id="adminButton"
                @click="setFunctionToTechnician"
                name="function"
                class="btn btn-danger btn-sm"
              >Admin</button>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="closeCreateUserModal">Close</button>
              <button type="button" @click="createUser" class="btn btn-primary">Save changes</button>
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
      user: {
        name: "",
        email: "",
        password: "",

        role_id: "2"
      },
      users: [],
      toast: toastr.options = {"positionClass":"toast-top-full-width"},

      uri: "http://raticate.test/users/"
    };
  },
  methods: {
    resetData(){
      this.user.name = "";
      this.user.password = "";
      this.user.email = "";
      this.user.role_id = "2";
    },
    openCreateUserModal() {
      this.user.role_id ="2"
      $("#adminButton").hide();
      $("#technicianButton").show();
      $("#create-modal").modal("show");
    },
    closeCreateUserModal() {
      
      $("#create-modal").modal("hide");
    },
    setFunctionToAdmin() {
      $("#technicianButton").hide();
      this.user.role_id = "1";
      $("#adminButton").show();
    },
    setFunctionToTechnician() {
      $("#adminButton").hide();
      this.user.role_id = "2";
      $("#technicianButton").show();
    },
    createUser() {
      axios
        .post(this.uri, { name: this.user.name, email: this.user.email, password: this.user.password, role_id: this.user.role_id})
        .then(response => {
          this.users.push(response.data.user);
          this.resetData();
          this.closeCreateUserModal()
          toastr.success(response.data.message);
          
        });
    },
    getUsers() {
      axios
        .get(this.uri, { name: "none", email: "none@none.com" })
        .then(response => {
          this.users = response.data.users;
        });
    },

    deleteUser(index){
      let confirmbox = confirm ("Do you realy want to delete this User ?");

      if(confirmbox== true){
        axios.delete(this.uri + this.users[index].id)
        .then(response => {this.$delete(this.users, index);
        }).catch(error =>{ console.log("could not delete")
        });
      }

    }

  },

  mounted() {
    console.log("Component mounted.");
    this.getUsers();
    toastr.info("LOaded");
  }
};
</script>
