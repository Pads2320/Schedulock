<h1>Welcome to <?php echo $_settings->info('name') ?></h1>
<hr>
<section class="content">
<div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-th-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Room Schedules</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM event_list")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Listed Students</span>
                <span class="info-box-number"> <?php echo $conn->query("SELECT * FROM students")->num_rows; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-th-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Classes with Lab Schedule</span>
                <span class="info-box-number"><?php  echo $conn->query("SELECT * FROM classes as a, class_schedule as b where b.class_id = a.id and b.date_end >= ".strtotime(date('Y-m-d H:i'))." group by a.id")->num_rows; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-th-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Currently Scheduled Class</span>
                <span class="info-box-number">
                  
                  <?php 


                    $day_today = date('l', strtotime(date('Y-m-d')));
                   
                    $class_query = $conn->query("SELECT * FROM classes");

                    $classes_array = array();

                    $has_scheduled = 0;

                    while($row_class = $class_query->fetch_assoc()){
                      $classes_array[$row_class['id']] = $row_class['class_name'];
                    }

                    $monday = $conn->query("SELECT * FROM class_schedule where unix_timestamp(date_start) <= ".strtotime(date('Y-m-d'))." and monday != '' and unix_timestamp(date_end) >= ".strtotime(date('Y-m-d')).""); 
                    $tuesday = $conn->query("SELECT * FROM class_schedule where unix_timestamp(date_start) <= ".strtotime(date('Y-m-d'))." and tuesday != '' and unix_timestamp(date_end) >= ".strtotime(date('Y-m-d')).""); 
                    $wednesday = $conn->query("SELECT * FROM class_schedule where unix_timestamp(date_start) <= ".strtotime(date('Y-m-d'))." and wednesday != '' and unix_timestamp(date_end) >= ".strtotime(date('Y-m-d')).""); 
                    $thursday = $conn->query("SELECT * FROM class_schedule where unix_timestamp(date_start) <= ".strtotime(date('Y-m-d'))." and thursday != '' and unix_timestamp(date_end) >= ".strtotime(date('Y-m-d')).""); 
                    $friday = $conn->query("SELECT * FROM class_schedule where unix_timestamp(date_start) <= ".strtotime(date('Y-m-d'))." and friday != '' and unix_timestamp(date_end) >= ".strtotime(date('Y-m-d')).""); 
                    $saturday = $conn->query("SELECT * FROM class_schedule where unix_timestamp(date_start) <= ".strtotime(date('Y-m-d'))." and saturday != '' and unix_timestamp(date_end) >= ".strtotime(date('Y-m-d')).""); 
                    $sunday = $conn->query("SELECT * FROM class_schedule where unix_timestamp(date_start) <= ".strtotime(date('Y-m-d'))." and sunday != '' and unix_timestamp(date_end) >= ".strtotime(date('Y-m-d')).""); 
                  
                    if($day_today == 'Monday'):

                      while($r_monday =  $monday->fetch_assoc()):

                        $time_schedule = $r_monday['monday'];
                        $time_sched_array = array();
                        $time_sched_array = explode('-',$time_schedule);

                        $time_start = $time_sched_array[0];                        
                        $time_end = $time_sched_array[1];

                        if($time_start <= date('H:i') && $time_end >= date('H:i')):
                          echo $classes_array[$r_monday['class_id']].' (Subject: '.$r_monday['subject_code'].')<br/>';
                          $has_scheduled += 1;
                        endif;

                      endwhile;                     

                    endif; // monday

                    if($day_today == 'Tuesday'):

                      while($r_tuesday =  $tuesday->fetch_assoc()):

                        $time_schedule = $r_tuesday['tuesday'];
                        $time_sched_array = array();
                        $time_sched_array = explode('-',$time_schedule);

                        $time_start = $time_sched_array[0];                        
                        $time_end = $time_sched_array[1];

                        if($time_start <= date('H:i') && $time_end >= date('H:i')):
                          echo $classes_array[$r_tuesday['class_id']].' (Subject: '.$r_tuesday['subject_code'].')<br/>';
                          $has_scheduled += 1;
                        endif;

                      endwhile;                     

                    endif; // tuesday
                    
                    if($day_today == 'Wednesday'):

                      while($r_wednesday =  $wednesday->fetch_assoc()):

                        $time_schedule = $r_wednesday['wednesday'];
                        $time_sched_array = array();
                        $time_sched_array = explode('-',$time_schedule);

                        $time_start = $time_sched_array[0];                        
                        $time_end = $time_sched_array[1];

                        if($time_start <= date('H:i') && $time_end >= date('H:i')):
                          echo $classes_array[$r_wednesday['class_id']].' (Subject: '.$r_wednesday['subject_code'].')<br/>';
                          $has_scheduled += 1;
                        endif;

                      endwhile;                     

                    endif; // wednesday

                     
                    if($day_today == 'Thursday'):

                      while($r_thursday =  $thursday->fetch_assoc()):

                        $time_schedule = $r_thursday['thursday'];
                        $time_sched_array = array();
                        $time_sched_array = explode('-',$time_schedule);

                        $time_start = $time_sched_array[0];                        
                        $time_end = $time_sched_array[1];

                        if($time_start <= date('H:i') && $time_end >= date('H:i')):
                          echo $classes_array[$r_thursday['class_id']].' (Subject: '.$r_thursday['subject_code'].')<br/>';
                          $has_scheduled += 1;
                        endif;

                      endwhile;                     

                    endif; // thursday
                    
                    if($day_today == 'Friday'):

                      while($r_friday =  $friday->fetch_assoc()):

                        $time_schedule = $r_friday['friday'];
                        $time_sched_array = array();
                        $time_sched_array = explode('-',$time_schedule);

                        $time_start = $time_sched_array[0];                        
                        $time_end = $time_sched_array[1];

                        if($time_start <= date('H:i') && $time_end >= date('H:i')):
                          echo $classes_array[$r_friday['class_id']].' (Subject: '.$r_friday['subject_code'].')<br/>';
                          $has_scheduled += 1;
                        endif;

                      endwhile;                     

                    endif; // friday

                    if($day_today == 'Saturday'):

                      while($r_saturday =  $saturday->fetch_assoc()):

                        $time_schedule = $r_saturday['saturday'];
                        $time_sched_array = array();
                        $time_sched_array = explode('-',$time_schedule);

                        $time_start = $time_sched_array[0];                        
                        $time_end = $time_sched_array[1];

                        if($time_start <= date('H:i') && $time_end >= date('H:i')):
                          echo $classes_array[$r_saturday['class_id']].' (Subject: '.$r_saturday['subject_code'].')<br/>';
                          $has_scheduled += 1;
                        endif;

                      endwhile;                     

                    endif; // saturday

                    if($day_today == 'Sunday'):

                      while($r_sunday =  $sunday->fetch_assoc()):

                        $time_schedule = $r_sunday['sunday'];
                        $time_sched_array = array();
                        $time_sched_array = explode('-',$time_schedule);

                        $time_start = $time_sched_array[0];                        
                        $time_end = $time_sched_array[1];

                        if($time_start <= date('H:i') && $time_end >= date('H:i')):
                          echo $classes_array[$r_sunday['class_id']].' (Subject: '.$r_sunday['subject_code'].')<br/>';
                          $has_scheduled += 1;
                        endif;

                      endwhile;                     

                    endif; // sunday

                    if($has_scheduled < 1):

                      echo "N/A";

                    endif;

                    
                  ?>
              
                </span>

              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
</section>