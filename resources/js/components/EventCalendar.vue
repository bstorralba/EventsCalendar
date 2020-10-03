<template>
	
	<div class="container-fluid">
		<h3>Calendar</h3>
		<hr>
		<div class="row">
			<div class="col-4" id="paramColumn">
				<form @submit.prevent="addEvent">
					<div class="form-group">
						<label for="forEvent">Event</label>
						<input type="text" class="form-control" id="forEvent" placeholder="Enter Task" v-model="event.event_name">
					</div>
					<!-- For dateRange textboxes -->
					<div class="form-row">
						<div class="col">
							<label for="dateFrom">From</label>
							<datepicker format="yyyy-MM-dd" v-model="event.date_from"></datepicker>
						</div>
						<div class="col">
							<label for="dateTo">To</label>
							<datepicker format="yyyy-MM-dd" v-model="event.date_to"></datepicker>
						</div>
					</div>
					<!-- Dates Checkboxes -->
					<div class="form-check form-check-inline" v-for="day in days">
						<input type="checkbox" class="form-check-input" :id="day.val" :value="day.val" v-model="event.days">
						<label class="form-check-label" :for="day.name">{{day.name}}</label>
					</div>
				</form>
				<button type="submit" class="btn btn-primary mt-2" @click="addEvent()">Save</button>
			</div>
			<div class="col-8" id="viewColumn">
					<h1> {{ currDate.month }} {{ currDate.year }} </h1>
					<table class="table">
					<tbody>
						<!-- template: hasValue -->
						<tr v-for="event in events" :key="event.eventDate">
							<th scope="row" >{{ event.dateName }} </th>
							<td>{{ event.eventName }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</template>

<script>

	import axios from 'axios'
	import Datepicker from 'vuejs-datepicker'
   	export default {
   		data(){
   			return{
   				events: [],
   				event: { days: [] },
   				days: [
   					{ name: 'Mon', val: 'Monday'},
   					{ name: 'Tue', val: 'Tuesday'},
   					{ name: 'Wed', val: 'Wednesday'},
   					{ name: 'Thu', val: 'Thursday'},
   					{ name: 'Fri', val: 'Friday'},
   					{ name: 'Sat', val: 'Saturday'},
   					{ name: 'Sun', val: 'Sunday'},
   				],
   				currDate: { month: "October", year: "2020"}
   			}
   		},
   		 components: {
		    Datepicker
		  },
   		created(){
   			try{
   				this.axios
                .get('http://localhost:8000/api/getEventsOfCurrMonth')
                .then(response => {
                    this.events = response.data;
                });
                this.isLoading = false;
   			}catch(e){

   			}
   		},
       mounted() {
       },
       methods: {
       		loadEvent(){
       			try{
	       			this.axios
		                .get('http://localhost:8000/api/getEventsOfCurrMonth')
		                .then(response => {
		                    this.events = response.data;
		                });
                }catch(e){

                }
       		},
       		addEvent() {
         			var hasError = false;

         			if(!this.event.event_name){
         				hasError |= true;
         			}

         			if(!this.event.date_from){
         				hasError |= true;
         			}

         			if(!this.event.date_to){
         				hasError |= true;
         			}

         			if(this.event.days.length <= 0){
         				hasError |= true;
         			}

         			if(hasError){
         				alert("All fields are required.");
         				return;
         			}

              var variantStat = 'success';
              this.axios
                  .post('http://localhost:8000/api/eventCalendar/addEventDates', this.event)
                  .then(response => {
                    if(response.status == '200'){
                      this.makeToast(true, variantStat);
                    }
                    this.loadEvent(true);

                  })
                  .catch(error => console.log(error))
                  .finally(() => this.loading = false)
          },
          makeToast(append = false, variantStat) {
            this.toastCount++
            this.$bvToast.toast(`Event successfuly saved`, {
              autoHideDelay: 5000,
              variant: variantStat,
              appendToast: append
            })
          }
       }
   }
</script>
