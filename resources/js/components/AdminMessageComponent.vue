<template>
  
  

  <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span v-if="jobsWithMessage" class="badge badge-danger badge-counter">{{jobsWithMessage.length}}</span><span v-else class="badge badge-danger badge-counter">0</span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Message Center 
                </h6>
                <a v-for="(job, index) in jobsWithMessage" class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                   
                    <i class="far fa-envelope-open fa-2x"></i>
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text">{{job.message}}</div>
                    <div class="small text-gray-500">{{job.city}} - {{job.address}}</div>
                  </div>
                </a>
               
                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
              </div>
            </li>
</template>

<script>
export default {
  data() {
    return {};
  },
  props: {

    jobs: Array
    
  },

  methods: {},

  computed: {

     jobsWithMessage: function () {
            return this.jobs.filter(job => {
                if (job.message !='' && job.message !=null){
                return job;
                }
            });
        }
  },
  mounted() {
    console.log("Messagecomponent mounted.");
  }
};
</script>
