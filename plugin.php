<?php
class pluginAdminTools extends Plugin {
private $enable;
public function siteHead()
{
    return '
    <style>
    .admin-tools-plugin {border:3px solid #aaaca7;background:#fafafa;line-height:125%;font-size:14px;margin:40px 0;-webkit-border-radius: 4px;-moz-border-radius: 4px; border-radius: 4px;display:table;width:100%;line-height:30px;}
    .admin-tools-plugin .dtl-cell {display:table-cell; width:80%; line-height:14px; padding:16px; background:#fff;vertical-align:middle; }
    .admin-tools-plugin .btn-cell {display:table-cell; width:20%; line-height:14px; background:#aaaca7; overflow:hidden; vertical-align:middle;}
    .admin-tools-plugin .admin-edit-item {display:inline-block;text-align:center;line-height:14px;color:#fff;width:100%;padding:5px;vertical-align:middle;}
    .admin-tools-plugin p {margin:0;padding:0;font-size:14px;color:#444;}
    .admin-tools-sidebar-plugin { border:1px solid #cecece; padding:16px; line-height:125%; font-size:14px; margin:40px 10px; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;}
    .admin-tools-sidebar-plugin ul {margin:0;padding:0;}
    .admin-tools-sidebar-plugin ul li {margin:0;padding:0;line-height:125%;list-style:none;}
    </style>
    ';
}

	public function pageEnd()
	{
    global $Login;
    global $L;
    global $Url;
    global $Site;
    global $Page;
    global $Users;
		if($Login->role()=='admin') {
      if($Url->whereAmI()=='page') {
			echo'<div class="admin-tools-plugin">';
          echo'<div class="dtl-cell">';
          echo '<p>'.$L->get('Page status').':<strong> '. $Page->status().'</strong> ';
          echo $L->get('Created on ').'<strong>'. $Page->dateRaw().'</strong> ';
          echo ' '.$L->get('by').' ';
          $username = $Page->username();
          echo '<strong>'.$username .'</strong>. ';
          if ($Page->dateModified()) {
          echo $L->get('Modified on').'<strong> '.$Page->dateModified().'</strong>';
          }
          echo'</p></div>';
          echo'<div class="btn-cell">';
         echo ' <a href="'.HTML_PATH_ADMIN_ROOT.'edit-content/';
           if ($Page->isChild()) {
           echo $Page->parentMethod('slug').'/';
           }
           echo $Page->slug().'" target="_blank" class="admin-edit-item">'.$L->get('Edit page').'</a>';
           echo'</div>';
        echo'</div>';
      };
		}
    if($Login->role()=='editor') {
      if($Url->whereAmI()=='page') {
        echo'<div class="admin-tools-plugin">';
            echo'<div class="dtl-cell">';
            echo '<p>'.$L->get('Page status').':<strong> '. $Page->status().'</strong> ';
            echo $L->get('Created on ').'<strong>'. $Page->dateRaw().'</strong> ';
            echo'</p></div>';
            echo'<div class="btn-cell">';
           echo ' <a href="'.HTML_PATH_ADMIN_ROOT.'edit-content/';
             if ($Page->isChild()) {
             echo $Page->parentMethod('slug').'/';
             }
             echo $Page->slug().'" target="_blank" class="admin-edit-item">'.$L->get('Edit page').'</a>';
             echo'</div>';
          echo'</div>';
      };
		}

		return false;
	}

  public function siteSidebar()
	{
    global $Login;
    global $L;
    global $Url;
    global $Site;
    global $Page;
    global $Users;
		if($Login->role()=='admin') {
    echo'
    <div class="admin-tools-sidebar-plugin">
    <ul class="info-list">
      <li >'.$L->get('Logged in as').': <a href="'.HTML_PATH_ADMIN_ROOT.'edit-user/'.$Login->username().'">'.$Login->username().'</a></li>
      <li><hr/></li>
      <li>'.$L->get('Locale').' <strong>'.$Site->locale().'</strong></li>
      <li>'.$L->get('Timezone').' <strong>'.$Site->timezone().'</strong></li>
      <li>'.$L->get('Theme').' <strong>'. $theme = $Site->theme().'</strong></li>
      <li>'.$L->get('Build').' <strong>'. $Site->currentBuild().'</strong></li>
      <li><hr/></li>
      <li><a href="'.HTML_PATH_ADMIN_ROOT.'" class="admin-panel">'.$L->get('Admin panel').'</a> </li>
      <li><hr/></li>
      <li><a href="'.HTML_PATH_ADMIN_ROOT.'new-content" class="admin-new-page">'.$L->get('New content').'</a></li>
      <li><hr/></li>
      <li class="float-me-to-the-right"><a href="'.HTML_PATH_ADMIN_ROOT.'/logout'.'" class="admin-page-logout">'.$L->get('Logout').'</a></li>
    </ul>
    </div>
    ';
	}
  if($Login->role()=='editor') {
  echo'
  <div class="admin-tools-sidebar-plugin">
  <h2 class="plugin-label">Editor tools</h2>
  <ul class="info-list">
    <li >'.$L->get('Logged in as').': <a href="'.HTML_PATH_ADMIN_ROOT.'edit-user/'.$Login->username().'">'.$Login->username().'</a> </li>
    <li><hr/></li>
    <li><a href="'.HTML_PATH_ADMIN_ROOT.'" class="admin-panel">'.$L->get('Admin panel').'</a> </li>
    <li><hr/></li>
    <li><a href="'.HTML_PATH_ADMIN_ROOT.'new-content" class="admin-new-page">'.$L->get('New content').'</a></li>
    <li><hr/></li>
    <li class="float-me-to-the-right"><a href="'.HTML_PATH_ADMIN_ROOT.'/logout'.'" class="admin-page-logout">'.$L->get('Logout').'</a></li>
  </ul>
  </div>
  ';
}

}

public function adminHead()
{
  global $Login;
  global $L;
  global $Url;
  global $Site;
  global $Page;
  global $dbPages;
  global $dbUsers;
echo '
<style>
.admin-tools-strip {background:#6a9333;color:#fff;padding:5px 10px;line-height:125%;font-size:14px;margin:0;}
@media (max-width: 959px) { .admin-tools-strip {display: none;} }
.admin-tools-strip p {margin:5px;padding:0;font-size:12px;color:#c5d7ae;}
.admin-tools-strip strong {color:#dae6ca;}
.admin-tools-strip .cta-btn {background:#fff;color:#6a9333;padding:5px;margin: 0 5px;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;border:1px solid #fff;text-decoration:none;}
.admin-tools-strip .cta-btn:hover {text-decoration:none;background:#6a9333;color:#c5d7ae;border:1px solid #c5d7ae;}
.admin-tools-strip .area {display:inline-block; margin:2px 10px;}
.admin-tools-strip .plugin-name {font-size:14px;font-weight:bold;color:#dae6ca;margin:2px 10px;}
</style>
';

  echo'
  <div class="admin-tools-strip">
    <p><span class="plugin-name">'.$L->get('Admin Tools').'</span> <span class="area"><strong>'.$L->get('Content').':</strong>
    static '.count($dbPages->getStaticDB(false)).',';
    $sticikies = method_exists($dbPages,'getStickyDB');
    if ($sticikies == 'true') {
    echo' sticky '.count($dbPages->getStickyDB(false)).', ';
    }
    echo' published '.count($dbPages->getPublishedDB(false)).'
    <a href="'.HTML_PATH_ADMIN_ROOT.'new-content" class="cta-btn">'.$L->get('New content').'</a></span>';
    if($Login->role()=='admin') {
    echo'<span class="area"><strong>'.$L->get('Users').'</strong>:
    '.$L->get('registered').' '.$dbUsers->count().'
    <a href="'.HTML_PATH_ADMIN_ROOT.'add-user" class="cta-btn">'.$L->get('Add a new user').'</a></span>';
    }
    ?>
    <script>
    var myVar = setInterval(function() {
      myTimer();
    }, 1000);
    function myTimer() {
      var d = new Date();
      document.getElementById("clock").innerHTML = d.toLocaleTimeString();
    }
    </script>
    <?php
    echo'<span class="area">'.$L->get('Time').': <strong id="clock"></strong></span></p>
  </div>
  ';
}
}
?>
