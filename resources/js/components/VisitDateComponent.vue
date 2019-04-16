<template>
  <div>
    <div class="row justify-content-center mt-1">
      <div class="col-10 mt-1" v-for="(date, index) in visitDates">
        <button
          @click="loadJobs(date.visitdate)"
          class="btn btn-dark btn-block shadow"
          type="button"
          data-toggle="collapse"
          :data-target="'#collapseExampl' + index"
          aria-expanded="false"
          aria-controls="collapseExample"
        >
          <div class="float-left">
            <i class="far fa-caret-square-down"></i>
          </div>

          <strong>{{formatDate(date.visitdate)}}</strong>
        </button>
        <div class="collapse" :id="'collapseExampl'+ index">
          <div class="card card-body">
            <div v-for="(job, index) in openJobs" class="btn-group">
              <button
                type="button"
                class="btn dropdown-toggle shadow-sm"
                @click="startInspection(index)"
                
                
              >
                {{job.address}}&nbsp; - &nbsp;{{job.city}}&nbsp;&nbsp;
                <div class="float-right">
                  
                  <i v-if="job.time" class="far fa-clock"></i>
                  <i v-if="job.callfirst" class="fas fa-phone"></i>
                </div>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
      <!-- Modal -->
    <div class="modal fade" id="visitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{activeJob.address}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row justify-content-center mt-1">
                <div class="col-10">
                    <div class=" mb-2"><strong>Comments:</strong></div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea disabled name="" v-model="activeJob.description" id="description" cols="30" rows="5"></textarea>
        
                    </div>
        
                    <div class="form-group">
                        <label for="observation">Observations:</label>
                        <textarea name="" v-model="activeJob.comments" id="observation" cols="30" rows="5"></textarea>
        
                    </div>
                    <div class=" mb-1"><strong>Cause:</strong></div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="voer" name="cause" class="custom-control-input">
                        <label class="custom-control-label" for="voer">Voer</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="vervuiling" name="cause" class="custom-control-input">
                        <label class="custom-control-label" for="vervuiling">Vervuiling</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="riool" name="cause" class="custom-control-input">
                        <label class="custom-control-label" for="riool">Riool</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="sloot" name="cause" class="custom-control-input">
                        <label class="custom-control-label" for="sloot">Sloot</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="vijver" name="cause" class="custom-control-input">
                        <label class="custom-control-label" for="vijver">Vijver</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="overig" name="cause" class="custom-control-input">
                        <label class="custom-control-label" for="overig">Overig</label>
                    </div>
                    <div><hr></div>
                    <!--Date Picker-->
                    <div class="form-group mt-2">
                        <div class=" mb-1"><strong>Next Visit:</strong></div>     
                    <input id="datepicker" width="276" />
                  
                    </div>

                    <div>
                       
                    <!-- Rounded switch -->
                <label class="switch">
                <input type="checkbox" name="finished">
                <span class="slider round"></span>
                </label>
                <strong>Problem Solved ?</strong>
        
            </div>
                   
                </div> <!-- end of column-->
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary " data-dismiss="modal">Back</button>
          <button type="button" class="btn btn-primary">End Visit</button>
        </div>
      </div>
    </div>
  </div>
  








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
      datesUri: "/loaddates/",
      jobsUri: "/loadjobs/",
      visitDates: [],
      openJobs: [],
      activeJob:[],
      
    };
  },
  props: {},

  methods: {
    getDates() {
      axios.get(this.datesUri).then(response => {
        this.visitDates = response.data.dates;
      });


      
    },

    startInspection(index){
      this.activeJob = this.openJobs[index];
      this.openModal('#visitModal')
    },

    openModal(modalId){
      $(modalId).modal("show");
        
      },

    loadJobs(date) {
      this.openJobs = [];
      axios
        .get(this.jobsUri, { params: { visitdate: date } })
        .then(response => {
          this.openJobs = response.data.jobs;
        });
    },

    formatDate(date) {
      return this.$parent.getFormattedDate(date);
    }
  },

  computed: {},
  mounted() {
    console.log("Tech side visitdate Component mounted.");
    this.getDates();
  }
};
</script>
