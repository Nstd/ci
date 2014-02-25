<nav class="navbar navbar-inverse " role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <b class="navbar-brand" ><?php //echo $title; ?></b>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
      <li><a href="javascript:user_management();" >用户管理</a></li>
      <li><a href="#">毕设管理</a></li>
      <?php 
        if ( $this->session->userdata("is_major_head") !== FALSE && 
             $this->session->userdata("is_major_head") == Bs::MAJOR_HEAD)
        {
          echo '<li><a href="#">设置评分项</a></li>';
        }
      ?>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><p class="navbar-text">欢迎:<?php echo $this->session->userdata("name");?></p></li>
      <li><a href="<?php echo $this->bs->site_url."/".$this->bs->getSiteUrl('login/logout');?>">[修改密码]</a></li>
      <li><a href="<?php echo $this->bs->site_url."/".$this->bs->getSiteUrl('login/logout');?>">[退出]</a></li>
      <li><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></li>
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>
<script type="text/javascript">
$(document).ready(function(){
  user_management();

  $("#info-submit").click(function(){
    var user_info = {"username": $("#inputUsername").val(), "usertype": $("#usertype").val(),"canlogin":$('input:radio[name="optionsRadios"]:checked').val()};
    $.ajax({
      url: '<?php echo "$site_url/$site_name" ?>/user/a_update_user',
      data: user_info,
      type: "POST",
      dataType: 'json',
      global: false,
      success: function(data) 
      { 
        if(!data)
        {
          alert("修改失败");
        }
        $('#myModal').modal('hide');
        user_management();
      }
    });
  });
});

function user_management(page)
{
  $.ajax({
            url: '<?php echo "$site_url/$site_name" ?>/user/a_user_list',
            type: "POST",
            dataType: 'json',
            data: {'page':page},
            global: false,
            success: function(data) {
              $('.table tbody').html(data.info); 
              $('.pagination').html(data.paging);
            }
          });
}

function get_userinfo(username)
{ 
  $.ajax({
    url: '<?php echo "$site_url/$site_name" ?>/user/a_load_info',
    type: "POST",
    global: false,
    dataType : 'json',
    data: {'username':username},
    success: function(data) {
      $("#inputUsername").val(data.username);
      $("#inputName").val(data.name);
      $("#usertype").val(data.type);
      $("input[name=optionsRadios]:eq(" + data.canlogin + ")").attr("checked",'checked'); 
      $('#myModal').modal('show');
    }
  });
}
</script>