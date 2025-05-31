


<script>
  $(document).ready(function(){
     window.viewer_modal = function($src = ''){
      start_loader()
      var t = $src.split('.')
      t = t[1]
      if(t =='mp4'){
        var view = $("<video src='"+$src+"' controls autoplay></video>")
      }else{
        var view = $("<img src='"+$src+"' />")
      }
      $('#viewer_modal .modal-content video,#viewer_modal .modal-content img').remove()
      $('#viewer_modal .modal-content').append(view)
      $('#viewer_modal').modal({
              show:true,
              backdrop:'static',
              keyboard:false,
              focus:true
            })
            end_loader()  

  }
    window.uni_modal = function($title = '' , $url='',$size=""){
        start_loader()
        $.ajax({
            url:$url,
            error:err=>{
                console.log()
                alert("An error occured")
            },
            success:function(resp){
                if(resp){
                    $('#uni_modal .modal-title').html($title)
                    $('#uni_modal .modal-body').html(resp)
                    if($size != ''){
                        $('#uni_modal .modal-dialog').addClass($size+'  modal-dialog-centered')
                    }else{
                        $('#uni_modal .modal-dialog').removeAttr("class").addClass("modal-dialog modal-md modal-dialog-centered")
                    }
                    $('#uni_modal').modal({
                      show:true,
                      backdrop:'static',
                      keyboard:false,
                      focus:true
                    })
                    end_loader()
                }
            }
        })
    }
    window._conf = function($msg='',$func='',$params = []){
       $('#confirm_modal #confirm').attr('onclick',$func+"("+$params.join(',')+")")
       $('#confirm_modal .modal-body').html($msg)
       $('#confirm_modal').modal('show')
    }
  })
</script>
<footer class="main-footer text-sm">
        <strong>Copyright © <?php echo date('Y') ?>. 
        <!-- <a href=""></a> -->
        </strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
          <b><?php echo $_settings->info('short_name') ?> (by: <a href="mailto:oretnom23@gmail.com" target="blank">oretnom23</a> )</b> v1.0
        </div>
      </footer>
    </div>
    <!-- ./wrapper -->
   
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="<?php echo base_url ?>plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="<?php echo base_url ?>plugins/sparklines/sparkline.js"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url ?>plugins/select2/js/select2.full.min.js"></script>
    <!-- JQVMap -->
    <script src="<?php echo base_url ?>plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="<?php echo base_url ?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo base_url ?>plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="<?php echo base_url ?>plugins/moment/moment.min.js"></script>
    <script src="<?php echo base_url ?>plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?php echo base_url ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->

  


    <script src="<?php echo base_url ?>plugins/summernote/summernote-bs4.min.js"></script>
    <script src="<?php echo base_url ?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <!-- overlayScrollbars -->
    <!-- <script src="<?php echo base_url ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script> -->
    <!-- AdminLTE App -->
    <script src="<?php echo base_url ?>dist/js/adminlte.js"></script>


    <div class="daterangepicker ltr show-ranges opensright">
      <div class="ranges">
        <ul>
          <li data-range-key="Today">Today</li>
          <li data-range-key="Yesterday">Yesterday</li>
          <li data-range-key="Last 7 Days">Last 7 Days</li>
          <li data-range-key="Last 30 Days">Last 30 Days</li>
          <li data-range-key="This Month">This Month</li>
          <li data-range-key="Last Month">Last Month</li>
          <li data-range-key="Custom Range">Custom Range</li>
        </ul>
      </div>
      <div class="drp-calendar left">
        <div class="calendar-table"></div>
        <div class="calendar-time" style="display: none;"></div>
      </div>
      <div class="drp-calendar right">
        <div class="calendar-table"></div>
        <div class="calendar-time" style="display: none;"></div>
      </div>
      <div class="drp-buttons"><span class="drp-selected"></span><button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button><button class="applyBtn btn btn-sm btn-primary" disabled="disabled" type="button">Apply</button> </div>
    </div>
    <div class="jqvmap-label" style="display: none; left: 1093.83px; top: 394.361px;">Idaho</div>


    
    <?php
      
      date_default_timezone_set('Asia/Manila');

      // Get the current date and time
      $currentDateTime = date('l Y-m-d H:i:s');

      $date_now  = date('Y-m-d');
      $time_now = date('H:i:s');
      $day_now  = date('l');

      // Output the current date and time
      //echo $currentDateTime;

    ?>


<!-- FIREBASE REALTIME DB START -->   
<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-database.js"></script>


<!-- FIREBASE REALTIME DB END -->   

<script type = "module">

  // Import the functions you need from the SDKs you need
  		import { initializeApp } from "https://www.gstatic.com/firebasejs/9.22.2/firebase-app.js";
          
        
		  // TODO: Add SDKs for Firebase products that you want to use
		  // https://firebase.google.com/docs/web/setup#available-libraries
		
		  // Your web app's Firebase configuration
		  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
		  const firebaseConfigApp = {

			apiKey: "AIzaSyB-vDxR2fkGz7BVN6JMA878lBEhWlK72fo",

			authDomain: "scheduled-door-access.firebaseapp.com",

			databaseURL: "https://scheduled-door-access-default-rtdb.firebaseio.com",

			projectId: "scheduled-door-access",

			storageBucket: "scheduled-door-access.firebasestorage.app",

			messagingSenderId: "822705278215",

			appId: "1:822705278215:web:51ca0c11c2c2b416e909a2"

		  };


		  const app = firebase.initializeApp(firebaseConfigApp);
		  const db = firebase.database();


      function isTimeInRange(currentTime, startTime, endTime) {
         return currentTime >= startTime && currentTime <= endTime;
      }

      const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

      var dbref_change = db.ref('door_access_session');
              // Listen for changes in the database
        dbref_change.on('child_changed', (snapshot) => {
          const changedKey = snapshot.key;  // The key of the changed child
          const newValue = snapshot.val();  // The new value of the changed child
          
          console.log(`Key changed: ${changedKey}`);
          console.log(`New value: ${newValue.is_logged_in}`);

        
          var class_id = newValue.class_id;
          var is_logged_in = newValue.is_logged_in;
          var is_professor = newValue.is_professor;
          var prof_qrcode = newValue.qrcode;
       

          const date_now = new Date();

       
          const currentDateNow = date_now.toLocaleDateString('en-CA', { timeZone: 'Asia/Manila' });

          // Get the time in Asia/Manila
          const currentTimeNow = date_now.toLocaleTimeString('en-GB', { timeZone: 'Asia/Manila', hour12: false });

          // Get the current day of the week (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
        
          const currentDayNow = daysOfWeek[date_now.getDay()];  // Outputs: "Thursday"

          var dbref_class = db.ref('class_schedule');

          dbref_class.once('value').then(function(dsnapshot){

            dsnapshot.forEach(function(childSnapshot) {

              var childData = childSnapshot.val();
              var professor_qrcode = childData.professor_qrcode;

              if(childData.class_id == class_id){

                var date_start = childData.date_start;
                var date_end = childData.date_end;
                var has_limit = childData.has_limit;
                var limit_time = childData.limit_time;

                var monday = childData.monday;
                var tuesday = childData.tuesday;
                var wednesday = childData.wednesday;  
                var thursday = childData.thursday;
                var friday = childData.friday;
                var saturday = childData.saturday;
                var sunday = childData.sunday;

              

                compare_date_time_execute_door_lock_process(currentDateNow,currentTimeNow, currentDayNow, has_limit, limit_time,date_start, date_end, is_logged_in, monday, tuesday, wednesday, thursday, friday, saturday, sunday);
                              
              }else{

                if(is_professor == '1'){


              

                  if(professor_qrcode == prof_qrcode){

                    var date_start = childData.date_start;
                    var date_end = childData.date_end;
                    var has_limit = childData.has_limit;
                    var limit_time = childData.limit_time;

                    var monday = childData.monday;
                    var tuesday = childData.tuesday;
                    var wednesday = childData.wednesday;  
                    var thursday = childData.thursday;
                    var friday = childData.friday;
                    var saturday = childData.saturday;
                    var sunday = childData.sunday;

                    compare_date_time_execute_door_lock_process(currentDateNow,currentTimeNow, currentDayNow, has_limit, limit_time,date_start, date_end, is_logged_in, monday, tuesday, wednesday, thursday, friday, saturday, sunday);

                  }else{

                    console.log("Professor Record Not Found");

                  }

                }

              } // if class_id not matched

            });

          });
     
         
          
        });

   

        function compare_date_time_execute_door_lock_process(currentDateNow, currentTimeNow,currentDayNow, has_limit,limit_time, date_start, date_end,isloggedin, monday, tuesday, wednesday, thursday, friday, saturday, sunday){

        
          if(currentDateNow >= date_start && currentDateNow <= date_end){
              
              var time_start = "";
              var time_end = "";
              var get_day = "";

                if(currentDayNow == "Monday"){

                  get_day = "monday";
                  time_start = monday.split('-')[0];
                  time_end = monday.split('-')[1];

                }else if(currentDayNow == "Tuesday"){
                  get_day = "tuesday";

                  time_start = tuesday.split('-')[0];
                  time_end = tuesday.split('-')[1];

                }else if(currentDayNow == "Wednesday"){
                  get_day = "wednesday";

                  time_start = wednesday.split('-')[0];
                  time_end = wednesday.split('-')[1];

                }else if(currentDayNow == "Thursday"){
                  get_day = "thursday";

                  time_start = thursday.split('-')[0];
                  time_end = thursday.split('-')[1];

                }else if(currentDayNow == "Friday"){
                  get_day = "friday";

                  time_start = friday.split('-')[0];
                  time_end = friday.split('-')[1];

                }else if(currentDayNow == "Saturday"){
                  get_day = "saturday";

                  time_start = saturday.split('-')[0];
                  time_end = saturday.split('-')[1];

                }else if(currentDayNow == "Sunday"){
                  get_day = "sunday";

                  time_start = sunday.split('-')[0];
                  time_end = sunday.split('-')[1];

                }else{
                  get_day = "";
                }

                let currentTimeHHMM = currentTimeNow.slice(0, 5); // This gets "hh:mm"


                console.log("Scheduled Day: "+get_day);
                console.log("Schedule Time Start: "+time_start);
                console.log("Schedule Time End: "+time_end);

                console.log("Time Now: "+currentTimeHHMM);

              
                if(isTimeInRange(currentTimeHHMM,time_start,time_end) == true){
                  
                  if(has_limit == "1"){


                    var registration_period = date_now.setMinutes(date_now.getMinutes() + limit_time);

                    if(registration_period >= currentTimeNow){

                      var dbref_door = db.ref('door_status').child('is_open_id_1');

                      dbref_door.set({
                        status: isloggedin
                      });

                      if(isloggedin == "1"){
                        console.log("Door Open");
                      }else{
                        console.log("Door Closed (Session not Finished Last Time)");
                      }

                    }else{
                      console.log("Limit Reach, Registration Time Out");
                    }

                  }
                  else{

                    var dbref_door = db.ref('door_status').child('is_open_id_1');

                    dbref_door.set({
                      status: isloggedin
                    });

                     if(isloggedin == "1"){
                        console.log("Door Open");
                      }else{
                        console.log("Door Closed (Session not Finished Last Time)");
                      }

                  }
                

                }else{
                  console.log("User Cannot Access from Time Range");
                }

                    



              }else{
              console.log("User Cannot Access from the Date Range");
              }


              var dbref_door = db.ref('door_status').child('is_open_id_1');

              dbref_door.set({
              status: isloggedin
              });

        }
    
      


    </script>


