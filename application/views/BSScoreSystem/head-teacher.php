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
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">评分<b class="caret"></b></a>
        <ul class="dropdown-menu">
          <?php
            if(isset($students) && count($students))
            {
              foreach($students as $row)
              {
                echo "<li><a href='$site_url/$site_name/teacher/t_score_table/" . $row['stu_id'] . "'>" . $row['name'] . "</a></li>";
              }
            }
            else
            {
              echo "<li><a href='#'>没有学生</a></li>";
            }
          ?>
        </ul>
      </li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">查看评分<b class="caret"></b></a>
        <ul class="dropdown-menu">
          <?php
            if(isset($students) && count($students))
            {
              foreach($students as $row)
              {
                echo "<li><a href=''>" . $row['name'] . "</a></li>";
              }
            }
            else
            {
              echo "<li><a href='#'>没有学生</a></li>";
            }
          ?>
        </ul>
      </li>
      <?php 
        if($this->session->userdata("is_major_head")  == Bs::MAJOR_HEAD)
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