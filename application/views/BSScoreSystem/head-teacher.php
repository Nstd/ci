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
      <li><a href="#">评分</a></li>
      <li><a href="#">查看评分</a></li>
      <li><a href="#">设置评分项</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><p class="navbar-text">欢迎:<?php echo $this->session->userdata("name");?></p></li>
      <li><a href="<?php echo $this->bs->site_url."/".$this->bs->getSiteUrl('login/logout');?>">[修改密码]</a></li>
      <li><a href="<?php echo $this->bs->site_url."/".$this->bs->getSiteUrl('login/logout');?>">[退出]</a></li>
      <li><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></li>
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>