
<div class="container">

<table align="center" bgcolor="#f6f6f6">
 <tr>
        <form id="data" name="el_data" action="{$ACTION_URL}" method="get">

                <td>{t}Choose date (dd-mm-aaaa format):{/t}</td>
                <td><input id="popup_container" type="text" name="str_data"
                        value="{$TODAY}"  on="javascript:hola();"/></td>
                <td><input type="submit" value="{t}Change{/t}"></td>
        </form>
        <form name="el_data_avui" action="{$ACTION_URL}" method="get"><input
                type="hidden" name="str_data" value="{$TODAY}">
        <td><input type="submit" value="{t}Today{/t}"></td>
        </form>
        </tr>
</table>

	
<table class="table table-striped table-bordered table-hover table-condensed">
 <thead style="background-color: #d9edf7;text-align: center;">
  <tr>
    <td colspan="5"> <?php echo $check_attendance_table_title?> | Dia: <?php echo $check_attendance_day?></td>
  </tr>
 </thead>
 <tbody>
  <!-- Iteration that shows teacher groups for selected day-->
  <?php foreach ($teacher_groups_current_day as $key => $teacher_group) : ?>
   <tr align="center" class="{cycle values='tr0,tr1'}">
     <td><?php echo $teacher_group->time_interval;?></td>
     <td><a href="<?php echo $teacher_group->group_url;?> "><?php echo $teacher_group->group_name;?></a></td>
     <td><?php echo $teacher_group->group_code;?></td>
   </tr>
  <?php endforeach; ?>
 </tbody>
</table>

</div>
