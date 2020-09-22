
  <div class="ui fixed inverted menu blue">
    <div class="ui container">
      <a href="/index.php" class="header item">
        <?php echo $projectName; ?>
      </a>
      
          <a href="/index.php" class="item"><?php echo \PhalApi\T('Home'); ?></a>
    
         <div class="item">
             <div class="ui form">
             <form action="/index.php?search=k" method="get" target="_blank">
                 <input type="text" name="keyword" placeholder="<?php echo \PhalApi\T('Search API'); ?>" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">
             </form>
             </div>
         </div>
         
     <div class="right menu">
         <div class="ui dropdown item">
         <?php echo \PhalApi\T('Language'); ?> <i class="dropdown icon"></i>
          <div class="menu">
              <a class="item" href="/index.php?language=zh_cn" >简体中文</a>
              <a class="item" href="/index.php?language=en" >English</a>
          </div>
        </div>
      </div>
      
        <div class="item">
		
        </div>
    </div>
  </div>
  

<div class="row" style="margin-top: 60px;" ></div>
