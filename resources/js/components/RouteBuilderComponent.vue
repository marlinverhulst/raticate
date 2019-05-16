<template>
  <div>
    <!-- Route Builder -->

    <a
      
      href="#"
      @click="openModal()"
      class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
    >
      <i class="fas fa-route fa-sm text-white-50"></i>
        Route Builder&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </a>
     <!-- Modal -->
    <div
      class="modal fade"
      id="RouteBuilderModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Route Builder</h5>
            <button type="button" class="close" @click="closeModal()" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-row mt-3">
                    <div class="col-12">
                      <select
                        name="selectClient"
                        id="selectClient"
                        v-model="selectedTechnician"
                        class="form-control"
                      >
                        <option disabled value>Select Technician</option>
                        
                        <option v-for="user in getTechnicians" :value="user.id">{{user.name}}</option>
                      </select>
                    </div>
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
  </div> <!-- End Of App -->
</template>

<script>
export default {
  data() {
    return {
      selectedTechnician: '',
      datesUri: 'routebuilder/'
      
    };
  },
  props: {

    users: Array 
    
  },

  methods: {

    getDates() {
      axios.get(this.datesUri).then(response => {
        this.visitDates = response.data.dates;
      });
    },

    openModal(){
      $('#RouteBuilderModal').modal('show');
    },
    closeModal(){
      $('#RouteBuilderModal').modal('hide');
    }
    
  },

  computed: {
     // Returns list of technicians filtered from Users
    getTechnicians: function() {
      return this.users.filter(user => {
        return user.role_id == 2;
      });
    },
  },
  mounted() {
    console.log("RouteBuilder mounted.");
  }
};
</script>
