<?php
if(!isset($_SESSION['sessid']))
	header("Location: ../index.php");
$building = new CBuilding;
$session->changeChecker();
?>
<link href="css/common.css" rel="stylesheet" type="text/css" media="screen">
<link href="css/forester.css" rel="stylesheet" type="text/css" media="screen">
<?php include("js/js1.php");?>
</head>
<body id="forester" dir="rtl">
 <div id="container">
  <div id="container2">
   <div id="header">
    <h1>إيكارياما ikariama</h1>
    <h2>عش في العصور القديمة!</h2>
   </div>
   <div id="avatarNotes"></div>
   <div id="breadcrumbs">
    <h3>أنت هنا:</h3>
    <a href="?view=worldmap_iso&amp;islandX=<?php echo $island->x;?>&amp;islandY=<?php echo $island->y;?>" title="عودة إلى خارطة العالم">
    <img src="img/resource/icon-world.gif" alt="عالم" />
    </a>
    <span>&nbsp;&gt;&nbsp;</span>
    <a href="?view=island&amp;id=<?php echo $island->iid;?>" title="عودة إلى الجزيرة">
    <img src="img/resource/icon-island.gif" alt="<?php echo $island->name?>" /><?php echo $island->name?>[<?php echo $island->x;?>:<?php echo $island->y;?>]</a>
    <span>&nbsp;&gt;&nbsp;</span>
    <a href="?view=city&amp;id=<?php echo $city->cid;?>" class="city" title="عودة إلى المدينة"><?php echo $city->cname;?></a>
    <span>&nbsp;&gt;&nbsp;</span>
    <span class="building">بيت الحطاب</span>
   </div>
   <div id="buildingUpgrade" class="dynamic">
    <h3 class="header">تطوير <a class="help" href="?view=buildingDetail&buildingId=19" title="مساعدة"><span class="textLabel">هل تحتاج لمساعدة؟</span></a></h3>
    <div class="content">
     <div class="buildingLevel">
      <span class="textLabel">مستوى </span>
	  <?php echo $building->currentLevel;?>
     </div><?php if($building->currentLevel<18){?>
     <h4>ضروري للمستوى <?php echo $building->getBuildingNextLevel($_GET["position"]);?>:</h4>
     <ul class="resources">
     <?php if($building->nextLevelRes["wood"] != 0){?>
      <li class="wood" title="مادة صناعية"><span class="textLabel">مادة صناعية: </span><?php echo number_format($building->nextLevelRes["wood"]);?>
      </li>
      <?php }if($building->nextLevelRes["marble"] != 0){?>
      	  <li class="marble alt" title="رخام"><span class="textLabel">رخام: </span><?php echo number_format($building->nextLevelRes["marble"]);?>
      </li>
      <?php }?>
      <li class="time" title="وقت البناء"><span class="textLabel">وقت البناء: </span>
	  <?php 
	  $time = $generator->getTimeFormat($building->nextLevelRes["time"]);
	  if($time["d"]) echo $time["d"]."يوم ";
	  if($time["h"] && $time["d"]) echo $time["h"]."س ";
	  else if($time["h"]) echo $time["h"]."ساعة ";
	  if($time["m"] && $time["h"]) echo $time["m"]."د ";
	  else if($time["m"]) echo $time["m"]."دقيقة ";
	  if($time["s"]) echo $time["s"]."ث ";
	  ?>
      </li>
      </ul>
     <ul class="actions">
      <li class="upgrade">
  <?php if(($building->currentLevel<18)&&$building->canBuild()&&$building->checkResource(12,$building->currentLevel+1)){?>  
      <a href="?action=CityScreen&function=upgradeBuilding&id=<?php echo $city->cid;?>&position=<?php echo $_GET["position"]?>&level=<?php echo $building->currentLevel;?>&actionRequest=<?php echo $session->checker;?>" title="في لائحة البناء!">
      <span class="textLabel">تحسين</span>
      </a>
  <?php  }else{?>
       <a class="disabled" href="#" title="إكمال الإنشاء غير ممكن حالياً"></a>
  <?php  }?>
      </li>
      <li class="downgrade">
  <?php  if(($building->currentLevel > 1)&& !$building->AmIUpgrading($_GET["position"])){?>
      <a href="?view=buildings_demolition&id=<?php echo $city->cid;?>&position=<?php echo $_GET["position"]?>&actionRequest=<?php echo $session->checker;?>" title="تدمير المبنى"><span class="textLabel">تدمير</span>
      </a>
  <?php }else{?>
      <a class="disabled" href="#" title="التدمير غير ممكن حالياً!"></a>
   <?php }?>
      </li>
      </ul><?php }?>  
    </div>
    <div class="footer"></div>
   </div>
   <div id="information" class="dynamic">
    <h3 class="header">في مستوى 2</h3>
    <div class="content">
    <table width="100%"><tr><th class="info center"><b>مادة أولية</b></th><th class="info center"><b>العلاوة</b></th></tr><tr><td class="info center"><img src="img/resource/icon_wood.gif" /></td><td class="info center">+<?php echo $building->getBuildingNextLevel($_GET["position"]);?>%</td>
</tr></table></div><div class="footer"></div>
   </div>
   <div id="mainview">
    <div id="bonusBuilding">
     <div class="buildingDescription">
      <h1>بيت الحطاب</h1>
<?php if($building->AmIUpgrading($_GET["position"])){?> 
 <div id="upgradeInProgress">
  <div class="buildingLevel">
   <span class="textLabel">مستوى </span>
   <?php echo $building->currentLevel;?>
  </div>
  <div class="nextLevel">
   <span class="textLabel">المستوى التالي </span>
   <?php echo $building->currentLevel+1;?>
  </div>
  <div class="isUpgrading">جاري إكمال الإنشاء</div>
  <div class="progressBar">
   <div class="bar" id="upgradeProgress" title="<?php echo $building->GetBUpPercent2Finish();?>%" style="width:<?php echo $building->GetBUpPercent2Finish();?>%;">
   </div>
  </div>
  <a class="cancelUpgrade" href="?view=buildings_demolition&id=<?php echo $city->cid;?>&position=<?php echo $_GET["position"];?>&actionRequest=<?php echo $session->checker;?>" title="إلغاء"><span class="textLabel">إلغاء</span>
  </a>
  <script type="text/javascript">
  Event.onDOMReady(function() {
   var tmppbar = getProgressBar({
   startdate: <?php echo $building->GetBUpgradingStartTime();?>,
   enddate: <?php echo $building->GetBUpgradingTime();?>,
   currentdate: <?php echo time();?>,
   bar: "upgradeProgress"});
   tmppbar.subscribe("update", function(){
    this.barEl.title=this.progress+"%";});
   tmppbar.subscribe("finished", function(){
    this.barEl.title="100%";});
	});
   </script>
   <div class="time" id="upgradeCountDown">
    <?php $time = $generator->getTimeFormat($building->GetBUpgradingTime()-time());
	  if($time["d"]) echo $time["d"]."يوم ";
	  if($time["h"] && $time["d"]) echo $time["h"]."س ";
	  else if($time["h"]) echo $time["h"]."ساعة ";
	  if($time["m"] && $time["h"]) echo $time["m"]."د ";
	  else if($time["m"]) echo $time["m"]."دقيقة ";
	  if($time["s"]) echo $time["s"]."ث ";
	  ?>
   </div>
   <script type="text/javascript">
   Event.onDOMReady(function() {
    var tmpCnt = getCountdown({
	 enddate: <?php echo $building->GetBUpgradingTime();?>,
	 currentdate: <?php echo time();?>,
	 el: "upgradeCountDown"}, 2, " ", "", true, true);
	 tmpCnt.subscribe("finished", function() {
	 setTimeout(function() {
	  location.href="?view=forester&id=<?php echo $city->cid;?>&position=<?php echo $_GET["position"];?>";
	 },2000);
	 });
	});
   </script>
 </div>
<?php }?>  
      <p>إن حطَّابي الخشب الأقوياء يستطيعون إسقاط أضخم الأشجار وأعلاها. كما أن يعلمون تماما أن الغابات يجب أن تكون مزروعة بالأشجار، وأن الأشجار الجديدة تحتاج إلى عناية لكي تنموا، لكي يتعذر استخدامها في بناء المنازل. تزداد كمية إنتاجك لمواد البناء مع كل تطوير لمستوى منزل عمال الغابة بنسبة 2% من القيمة الأساسية.</p>
     </div>
     <div class="contentBox01h">
      <div class="buildingPictureImg"><img src="img/city/small/building_forester.gif" /></div>
      <h3 class="header"><span class="textLabel">إنتاج الخشب</span></h3>
      <div class="content">
<?php 
$exwoodp = round($city->woodworkers*($building->currentLevel/100));
$sump = $exwoodp + $city->woodworkers;
?>
       <table ccellspacing="0" border="0" style="margin:0 auto 0px;"><colgroup><col width="150"/><col width="70"/><col width="%"/></colgroup>
       <tr><th class='brownHeader' colspan="3"></th></tr>
       <tr><td class="col1Style"><label>الإنتاج الأساسي: </label></td><td class="col2Style"><span title="الإنتاج الأساسي"><?php echo $city->woodworkers;?>.00</span></td></td><td class="col3Style"><div class="green" style="width:<?php echo round($city->woodworkers*99/$sump);?>%" title="100.00%"></div></td></tr>
       <tr class='alt'><td class="col1Style"><label>بيت الحطاب: </label>
       </td><td class="col2Style">
       <span title="بيت الحطاب"><?php echo $exwoodp?>.00</span>
       </td><td class="col3Style">
       <div class="yellow" style="width:<?php echo round($exwoodp*99/$sump);?>%" title="+<?php echo $building->currentLevel?>.00%">
       </div>
       </td>
       </tr>
       <tr class="buildingResult">
       <td class="col1Style"><img src="img/sigma.gif"/></td><td class="col2Style"><span title="مجموع"><b><?php echo $sump;?>.00</b></span>
       </td><td class="col3Style">
       <div class="green" style="width:99%" title="102.00%">
       </div></td></tr></table>
      </div>
      <div class="footer"></div>
     </div>
    </div>
</div>
<?php include("citynavigator.php");?>
<?php include("footer.php");?>
<?php include("toolbar.php");?>
 </div>
</div>
<?php include("js/js2.php");?>