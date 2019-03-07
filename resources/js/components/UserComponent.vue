<template>
  <div class="col-6">
    <!-- Area Chart -->
    <div>
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
            <table class="table" v-if="users.length > 0">
              <thead>
                <tr>
                  <!-- <th scope="col">Id</th> -->
                  <th style="width: 30%" scope="col">Name</th>
                  <!-- <th scope="col">E-mail</th> -->
                  <th style="width: 30%" scope="col">Function</th>
                  <th style="width: 10%" scope="col"></th>
                  <th style="width: 10%" scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(user, index) in users">
                  <!-- <td>{{index + 1}}</td> -->
                  <td>{{user.name}}</td>
                  <!-- <td>{{user.email}}</td> -->
                  <td v-if="user.role_id == 1">Admin</td>
                  <td v-else>Technician</td>
                  <td>
                    <i @click="openEditUserModal(index)" class="fas fa-tools fa-1x"></i>
                  </td>
                  <td>
                    <i @click="deleteUser(index)" class="fas fa-minus-circle fa-1x"></i>
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
    <!-- Update Modal -->
    <div
      class="modal fade"
      id="update-user-modal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
            <button type="button" class="close" @click = "closeUserUpdateModal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="updateusernamename">Name:</label>
              <input
                v-model="new_update_user.name"
                type="text"
                id="updateusername"
                class="form-control"
              >
            </div>
            <div class="form-group">
              <label for="updateuseremail">E-mail</label>
              <input
                type="email"
                v-model="new_update_user.email"
                id="updateuseremail"
                class="form-control"
              >
            </div>
            <div class="form-group">
              <label for="updateuserpassword">Password:</label>
              <input
                type="password"
                v-model="new_update_user.password"
                id="updateuserpassword"
                class="form-control"
              >
            </div>
            <div class="form-group">
              <label for="updateuserfunction">Function:</label>
              <button
                type="button"
                id="technicianUpdateButton"
                name="function"
                @click="setUpdateFunctionToAdmin"
                class="btn btn-primary btn-sm"
              >Technician</button>
              <button
                type="button"
                id="adminUpdateButton"
                @click="setUpdateFunctionToTechnician"
                name="function"
                class="btn btn-danger btn-sm"
              >Admin</button>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="closeUserUpdateModal()">Close</button>
              <button type="button" @click="updateUser()" class="btn btn-primary">Save changes</button>
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
      new_update_user: [],
      
      restoreUser: {},

      errors: [],
      toast: (toastr.options = { positionClass: "toast-top-full-width" }),

      uri: "/users/"
    };
  },
  methods: {
    openEditUserModal(index) {
      this.errors = [];

      this.new_update_user = this.users[index];

      // resores User to previous when canceled 

      this.restoreUser = Object.assign({},this.users[index]);

      if (this.new_update_user.role_id == "2") {
        $("#adminUpdateButton").hide();
        $("#technicianUpdateButton").show();
      } else {
         $("#adminUpdateButton").show();
        $("#technicianUpdateButton").hide();
      }
      $("#update-user-modal").modal("show");
    },
    closeUserUpdateModal() {
      Object.assign(this.new_update_user, this.restoreUser);
      this.restoreUser = null ;
      $("#update-user-modal").modal("hide");
    },
    resetData() {
      this.user.name = "";
      this.user.password = "";
      this.user.email = "";
      this.user.role_id = "2";
    },
    updateUser() {
      axios
        .patch(this.uri + this.new_update_user.id, {
          name: this.new_update_user.name,
          password: this.new_update_user.password,
          email: this.new_update_user.email,
          role_id: this.new_update_user.role_id
        })
        .then(response => {
          $('#update-user-modal').modal('hide');
        })
        .catch(error => {
          console.log(error);
        });
    },
    openCreateUserModal() {
      
      this.resetData();
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
    setUpdateFunctionToTechnician() {
      $("#adminUpdateButton").hide();
      this.new_update_user.role_id = "2";
      $("#technicianUpdateButton").show();
    },
    setUpdateFunctionToAdmin() {
      $("#technicianUpdateButton").hide();
      this.new_update_user.role_id = "1";
      $("#adminUpdateButton").show();
    },
    createUser() {
      axios
        .post(this.uri, {
          name: this.user.name,
          email: this.user.email,
          password: this.user.password,
          role_id: this.user.role_id
        })
        .then(response => {
          this.users.push(response.data.user);
          this.resetData();
          this.closeCreateUserModal();
          toastr.success(response.data.message);
        }).catch(error => {console.log(error);});
    },
    getUsers() {
      axios
        .get(this.uri, { name: "none", email: "none@none.com" })
        .then(response => {
          this.users = response.data.users;
        });
    },

    deleteUser(index) {
      let confirmbox = confirm("Do you realy want to delete this User ?");

      if (confirmbox == true) {
        axios
          .delete(this.uri + this.users[index].id)
          .then(response => {
            this.$delete(this.users, index);
          })
          .catch(error => {
            console.log("could not delete");
          });
      }
    }
  },

  mounted() {
    console.log("Users Component mounted.");
    this.getUsers();
    toastr.info("LOaded");
  }
};
</script>
